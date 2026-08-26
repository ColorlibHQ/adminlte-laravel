<?php

namespace ColorlibHQ\AdminLte\Tests\Fixtures;

use Illuminate\Foundation\Auth\User;

/**
 * A user model that does not live in `users` — the case NavbarData has to
 * resolve rather than assume.
 */
class Member extends User
{
    protected $table = 'members';

    protected $guarded = [];

    public $timestamps = false;
}
