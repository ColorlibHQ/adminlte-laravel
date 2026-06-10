<?php

namespace ColorlibHQ\AdminLte\Tests;

class DocsDisabledTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('adminlte.docs', false);
    }

    public function test_docs_routes_are_not_registered_when_disabled(): void
    {
        $this->get('/docs')->assertNotFound();
        $this->get('/docs/installation')->assertNotFound();
    }
}
