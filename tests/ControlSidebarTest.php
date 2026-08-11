<?php

namespace ColorlibHQ\AdminLte\Tests;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\HtmlString;

class ControlSidebarTest extends TestCase
{
    public function test_renders_nothing_when_disabled(): void
    {
        $this->withoutVite();

        $html = view('adminlte::page')->render();

        $this->assertStringNotContainsString('adminlte-control-sidebar', $html);
        $this->assertStringNotContainsString('data-bs-toggle="offcanvas"', $html);
    }

    public function test_renders_an_offcanvas_and_its_navbar_toggle_when_enabled(): void
    {
        $this->withoutVite();
        Config::set('adminlte.control_sidebar', true);

        $html = view('adminlte::page')->render();

        $this->assertStringContainsString('class="offcanvas offcanvas-end"', $html);
        $this->assertStringContainsString('id="adminlte-control-sidebar"', $html);

        // The panel is useless without something to open it — the navbar toggle
        // has to appear under the same flag and point at the same element.
        $this->assertStringContainsString('data-bs-toggle="offcanvas"', $html);
        $this->assertStringContainsString('data-bs-target="#adminlte-control-sidebar"', $html);
        $this->assertStringContainsString('aria-controls="adminlte-control-sidebar"', $html);
    }

    public function test_no_adminlte_3_markup_survives(): void
    {
        $this->withoutVite();
        Config::set('adminlte.control_sidebar', true);

        $html = view('adminlte::page')->render();

        // AdminLTE 4 ships no CSS, no JS and no handler for any of these — they
        // are v3 leftovers that rendered an unstyled, unopenable block.
        $this->assertStringNotContainsString('data-lte-toggle="control-sidebar"', $html);
        $this->assertStringNotContainsString('class="control-sidebar', $html);
        $this->assertStringNotContainsString('control-sidebar-content', $html);
    }

    public function test_theme_is_applied_as_a_bootstrap_theme_attribute(): void
    {
        Config::set('adminlte.control_sidebar', true);
        Config::set('adminlte.control_sidebar_theme', 'light');

        $html = view('adminlte::partials.control-sidebar')->render();

        $this->assertStringContainsString('data-bs-theme="light"', $html);
    }

    public function test_body_accepts_content_from_a_section_a_stack_or_a_slot(): void
    {
        Config::set('adminlte.control_sidebar', true);

        $pushed = Blade::render(
            '@push("control_sidebar")<p>pushed</p>@endpush'."\n"
            .'@include("adminlte::partials.control-sidebar")'
        );
        $this->assertStringContainsString('<p>pushed</p>', $pushed);

        $sectioned = Blade::render(
            '@section("control_sidebar")<p>sectioned</p>@endsection'."\n"
            .'@include("adminlte::partials.control-sidebar")'
        );
        $this->assertStringContainsString('<p>sectioned</p>', $sectioned);

        // `$slot` goes through {{ }}, so markup has to arrive as Htmlable — the
        // same contract a real component slot satisfies, and plain strings stay
        // escaped rather than becoming an injection point.
        $slotted = view('adminlte::partials.control-sidebar', [
            'slot' => new HtmlString('<p>slotted</p>'),
        ])->render();
        $this->assertStringContainsString('<p>slotted</p>', $slotted);

        $escaped = view('adminlte::partials.control-sidebar', ['slot' => '<script>x</script>'])->render();
        $this->assertStringNotContainsString('<script>x</script>', $escaped);
    }

    public function test_panel_is_labelled_for_assistive_tech(): void
    {
        Config::set('adminlte.control_sidebar', true);

        $html = view('adminlte::partials.control-sidebar')->render();

        $this->assertStringContainsString('aria-labelledby="adminlte-control-sidebar-label"', $html);
        $this->assertStringContainsString('id="adminlte-control-sidebar-label"', $html);
        $this->assertStringContainsString('data-bs-dismiss="offcanvas"', $html);
    }
}
