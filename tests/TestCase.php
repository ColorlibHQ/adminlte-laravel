<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\AdminLteServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [AdminLteServiceProvider::class];
    }
}
