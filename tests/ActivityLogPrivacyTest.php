<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Support\ActivityLogger;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ActivityLogPrivacyTest extends TestCase
{
    private const MIGRATION = '/database/migrations/2026_09_30_000000_redact_secrets_in_adminlte_activity_log.php';

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        ActivityLogger::flushTableCache();
    }

    protected function tearDown(): void
    {
        ActivityLogger::flushTableCache();

        parent::tearDown();
    }

    /** The table `adminlte:scaffold activity-log` publishes. */
    private function createAdminLteActivityTable(): void
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('event');
            $table->string('description')->nullable();
            $table->nullableMorphs('subject');
            $table->json('properties')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * @return array<string, mixed>|null
     */
    private function storedProperties(int $id): ?array
    {
        $json = DB::table('activity_log')->where('id', $id)->value('properties');

        return $json === null ? null : json_decode((string) $json, true);
    }

    private function runMigration(): void
    {
        (require dirname(__DIR__).self::MIGRATION)->up();
    }

    public function test_redact_drops_credential_like_keys_at_any_depth(): void
    {
        $clean = ActivityLogger::redact([
            'name' => 'Ada',
            'password' => '$2y$12$hash',
            'Password_Confirmation' => 'secret',
            'remember_token' => 'tok',
            'two_factor_secret' => 'JBSWY3DPEHPK3PXP',
            'two_factor_recovery_codes' => '["a","b"]',
            'api_key' => 'sk_live_x',
            'apiKey' => 'sk_live_y',
            'private_key' => '-----BEGIN',
            'settings' => ['theme' => 'dark', 'client_secret' => 'cs', 'nested' => ['access_token' => 'at', 'keep' => 1]],
            'email' => 'ada@example.com',
        ]);

        $this->assertSame([
            'name' => 'Ada',
            'settings' => ['theme' => 'dark', 'nested' => ['keep' => 1]],
            'email' => 'ada@example.com',
        ], $clean);
    }

    public function test_redact_drops_hidden_attributes_and_configured_keys(): void
    {
        config(['adminlte.activity_log.redact' => ['ssn']]);

        $this->assertSame(
            ['name' => 'Ada'],
            ActivityLogger::redact(['name' => 'Ada', 'pin' => '1234', 'ssn' => '078-05-1120'], ['pin']),
        );
    }

    public function test_log_never_stores_the_subjects_hidden_attributes_or_credentials(): void
    {
        $this->createAdminLteActivityTable();

        $user = new class extends User
        {
            protected $table = 'users';

            protected $hidden = ['password', 'remember_token', 'pin_code'];
        };
        $user->forceFill(['id' => 7]);

        ActivityLogger::log('updated', 'User updated', [
            'name' => 'Ada',
            'password' => '$2y$12$hash',
            'pin_code' => '4321',
            'api_token' => 'plain-token',
        ], $user, 1);

        $row = DB::table('activity_log')->first();

        $this->assertNotNull($row);
        $this->assertSame(['name' => 'Ada'], json_decode((string) $row->properties, true));
        $this->assertStringNotContainsString('hash', (string) $row->properties);
    }

    public function test_log_stores_null_when_only_secrets_were_given(): void
    {
        $this->createAdminLteActivityTable();

        ActivityLogger::log('updated', 'Password changed', ['password' => '$2y$12$hash'], null, 1);

        $this->assertNull(DB::table('activity_log')->value('properties'));
    }

    public function test_migration_removes_secrets_logged_by_earlier_versions_and_keeps_the_rest(): void
    {
        $this->createAdminLteActivityTable();

        $insert = fn (?string $subjectType, ?array $properties) => DB::table('activity_log')->insertGetId([
            'user_id' => 1,
            'event' => 'updated',
            'description' => 'User updated',
            'subject_type' => $subjectType,
            'subject_id' => $subjectType ? 1 : null,
            'properties' => $properties === null ? null : json_encode($properties),
            'ip_address' => '10.0.0.1',
            'created_at' => now(),
        ]);

        $mixed = $insert(User::class, [
            'name' => 'Ada',
            'password' => '$2y$12$hash',
            'remember_token' => 'tok',
            'two_factor_secret' => 'JBSWY3DPEHPK3PXP',
        ]);
        $secretsOnly = $insert(User::class, ['password' => '$2y$12$hash']);
        $failedLogin = $insert(null, ['email' => 'someone@example.com']);
        $mentionsOnly = $insert(null, ['note' => 'rotated the api key', 'keyboard' => 'uk']);
        $empty = $insert(null, null);

        $this->runMigration();

        $this->assertSame(['name' => 'Ada'], $this->storedProperties($mixed));
        $this->assertNull($this->storedProperties($secretsOnly));
        $this->assertSame(['email' => 'someone@example.com'], $this->storedProperties($failedLogin));
        $this->assertSame(['note' => 'rotated the api key', 'keyboard' => 'uk'], $this->storedProperties($mentionsOnly));
        $this->assertNull($this->storedProperties($empty));
        $this->assertSame('10.0.0.1', DB::table('activity_log')->where('id', $mixed)->value('ip_address'));
    }

    public function test_migration_leaves_a_spatie_activity_log_table_alone(): void
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject');
            $table->nullableMorphs('causer');
            $table->json('properties')->nullable();
            $table->timestamps();
        });
        $id = DB::table('activity_log')->insertGetId([
            'description' => 'updated',
            'properties' => json_encode(['attributes' => ['password' => 'x']]),
        ]);

        $this->runMigration();

        $this->assertSame(['attributes' => ['password' => 'x']], $this->storedProperties($id));
    }

    public function test_migration_is_a_no_op_without_the_table(): void
    {
        $this->runMigration();

        $this->assertFalse(Schema::hasTable('activity_log'));
    }

    public function test_package_migrations_are_registered_with_the_migrator(): void
    {
        $paths = $this->app['migrator']->paths();

        $this->assertContains(realpath(dirname(__DIR__).'/database/migrations'), array_map('realpath', $paths));
    }
}
