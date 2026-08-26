<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Support\NavbarData;
use ColorlibHQ\AdminLte\Tests\Fixtures\Member;
use Illuminate\Auth\GenericUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use ReflectionProperty;

class NavbarDataTest extends TestCase
{
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

        // The table-existence checks are memoized for the life of the request,
        // which in PHPUnit is the life of the process — reset them per test.
        foreach (['hasNotificationsTable', 'hasMessagesTable'] as $property) {
            (new ReflectionProperty(NavbarData::class, $property))->setValue(null, null);
        }
    }

    public function test_notifications_fall_back_to_demo_data_for_guests(): void
    {
        $notifications = NavbarData::notifications();

        $this->assertNotEmpty($notifications);
        $this->assertArrayHasKey('icon', $notifications[0]);
        $this->assertArrayHasKey('text', $notifications[0]);
        $this->assertArrayHasKey('time', $notifications[0]);
    }

    public function test_notification_count_falls_back_to_demo_count(): void
    {
        $this->assertSame(count(NavbarData::notifications()), NavbarData::notificationCount());
    }

    public function test_messages_fall_back_to_demo_data_for_guests(): void
    {
        $messages = NavbarData::messages();

        $this->assertNotEmpty($messages);
        $this->assertArrayHasKey('name', $messages[0]);
    }

    public function test_demo_data_respects_limit(): void
    {
        $this->assertLessThanOrEqual(2, count(NavbarData::notifications(2)));
    }

    public function test_messages_join_the_table_of_a_custom_user_model(): void
    {
        $this->createUsersTable('members');
        $this->createMessagesTable();

        DB::table('members')->insert([
            ['id' => 1, 'name' => 'Ann Sender'],
            ['id' => 2, 'name' => 'Bob Recipient'],
        ]);
        $this->insertMessage(from: 1, to: 2, subject: 'Server is on fire');

        $this->actingAs(Member::query()->find(2));

        $messages = NavbarData::messages();

        $this->assertCount(1, $messages);
        $this->assertSame('Ann Sender', $messages[0]['name']);
        $this->assertSame('Server is on fire', $messages[0]['text']);
        $this->assertSame(1, NavbarData::messageCount());
    }

    public function test_messages_join_the_table_of_a_non_eloquent_user(): void
    {
        // The `database` auth provider hands back a GenericUser, which has no
        // getTable() at all — the table has to come from the provider config.
        config()->set('auth.guards.web.provider', 'members');
        config()->set('auth.providers.members', ['driver' => 'database', 'table' => 'members']);

        $this->createUsersTable('members');
        $this->createMessagesTable();

        DB::table('members')->insert([
            ['id' => 1, 'name' => 'Ann Sender'],
            ['id' => 2, 'name' => 'Bob Recipient'],
        ]);
        $this->insertMessage(from: 1, to: 2, subject: 'Still on fire');

        Auth::setUser(new GenericUser(['id' => 2, 'name' => 'Bob Recipient']));

        $messages = NavbarData::messages();

        $this->assertCount(1, $messages);
        $this->assertSame('Ann Sender', $messages[0]['name']);
    }

    public function test_messages_still_read_the_default_users_table(): void
    {
        $this->createUsersTable('users');
        $this->createMessagesTable();

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Ann Sender'],
            ['id' => 2, 'name' => 'Bob Recipient'],
        ]);
        $this->insertMessage(from: 1, to: 2, subject: 'Hello');

        $user = new User;
        $user->forceFill(['id' => 2]);
        $this->actingAs($user);

        $messages = NavbarData::messages();

        $this->assertCount(1, $messages);
        $this->assertSame('Ann Sender', $messages[0]['name']);
    }

    private function createUsersTable(string $name): void
    {
        Schema::create($name, function (Blueprint $table): void {
            $table->integer('id')->primary();
            $table->string('name');
        });
    }

    private function createMessagesTable(): void
    {
        Schema::create('adminlte_messages', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('from_user_id');
            $table->integer('to_user_id');
            $table->string('subject');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->nullable();
        });
    }

    private function insertMessage(int $from, int $to, string $subject): void
    {
        DB::table('adminlte_messages')->insert([
            'from_user_id' => $from,
            'to_user_id' => $to,
            'subject' => $subject,
            'is_read' => false,
            'created_at' => now(),
        ]);
    }
}
