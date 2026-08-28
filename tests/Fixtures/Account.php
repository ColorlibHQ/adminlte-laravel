<?php

namespace ColorlibHQ\AdminLte\Tests\Fixtures;

use Illuminate\Foundation\Auth\User;

/**
 * A user model that is neither named `User` nor sitting in `App\Models` — the
 * case scaffolded code has to name explicitly rather than resolve by convention.
 */
class Account extends User
{
    protected $table = 'accounts';

    protected $guarded = [];

    public $timestamps = false;
}
