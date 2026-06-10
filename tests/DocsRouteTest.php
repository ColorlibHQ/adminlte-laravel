<?php

namespace ColorlibHQ\AdminLte\Tests;

class DocsRouteTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        // The docs routes run through the `web` middleware group, whose
        // encrypted-cookie/session layers need an app key.
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }

    protected function setUp(): void
    {
        parent::setUp();

        // The docs layout calls @vite; no manifest exists under Testbench.
        $this->withoutVite();
    }

    public function test_docs_index_renders(): void
    {
        $this->get('/docs')
            ->assertOk()
            ->assertSee('AdminLTE', false);
    }

    public function test_docs_page_renders_markdown(): void
    {
        $this->get('/docs/installation')
            ->assertOk()
            ->assertSee('Installation');
    }

    public function test_unknown_page_returns_404(): void
    {
        $this->get('/docs/definitely-not-a-page')->assertNotFound();
    }

    public function test_traversal_attempts_are_rejected(): void
    {
        // Sanitized to a slug that does not exist → 404, never file disclosure.
        $this->get('/docs/..%2F..%2F..%2Fetc%2Fpasswd')->assertNotFound();
        $this->get('/docs/....//....//etc/passwd')->assertNotFound();
    }

    public function test_intra_doc_links_are_rewritten(): void
    {
        $response = $this->get('/docs/README');

        $response->assertOk();
        // Markdown links like (installation.md) must point at /docs/installation.
        $this->assertStringNotContainsString('href="installation.md"', $response->getContent());
    }
}
