<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Support\UserTable;
use ColorlibHQ\AdminLte\Tests\Fixtures\Member;
use Illuminate\Auth\GenericUser;

class UserTableTest extends TestCase
{
    public function test_it_defaults_to_the_conventional_table(): void
    {
        $this->assertSame('users', UserTable::name());
    }

    public function test_an_eloquent_user_answers_for_itself(): void
    {
        $this->assertSame('members', UserTable::name(new Member));
    }

    public function test_it_reads_the_table_off_a_database_provider(): void
    {
        config()->set('auth.guards.web.provider', 'members');
        config()->set('auth.providers.members', ['driver' => 'database', 'table' => 'members']);

        // The `database` provider's user has no table of its own to report.
        $this->assertSame('members', UserTable::name(new GenericUser(['id' => 1])));
        $this->assertSame('members', UserTable::name());
    }

    public function test_it_reads_the_table_off_an_eloquent_provider_model(): void
    {
        config()->set('auth.guards.web.provider', 'members');
        config()->set('auth.providers.members', ['driver' => 'eloquent', 'model' => Member::class]);

        // No authenticated user to ask — the configured model has to answer.
        $this->assertSame('members', UserTable::name());
    }

    public function test_it_falls_back_when_the_provider_model_does_not_resolve(): void
    {
        config()->set('auth.guards.web.provider', 'members');
        config()->set('auth.providers.members', ['driver' => 'eloquent', 'model' => 'App\\Models\\Nonexistent']);

        $this->assertSame('users', UserTable::name());
    }
}
