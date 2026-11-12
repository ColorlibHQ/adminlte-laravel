<?php

namespace ColorlibHQ\AdminLte\Tests;

use ColorlibHQ\AdminLte\Support\ThemeColors;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\DataProvider;

class ThemeColorsTest extends TestCase
{
    public function test_emits_nothing_when_no_color_is_configured(): void
    {
        $this->assertSame('', ThemeColors::styles());
    }

    public function test_normalize_accepts_hex_and_expands_shorthand(): void
    {
        $this->assertSame('#0d6efd', ThemeColors::normalize('#0D6EFD'));
        $this->assertSame('#aabbcc', ThemeColors::normalize('#abc'));
        $this->assertSame('#ffffff', ThemeColors::normalize('  #FFF  '));
    }

    /**
     * The output is rendered unescaped inside a <style> element, so anything
     * that is not a plain hex colour has to be dropped rather than sanitised.
     *
     * @param  mixed  $value
     */
    #[DataProvider('invalid_colors')]
    public function test_normalize_rejects_everything_else($value): void
    {
        $this->assertNull(ThemeColors::normalize($value));
    }

    /**
     * @return array<string, array{0: mixed}>
     */
    public static function invalid_colors(): array
    {
        return [
            'null' => [null],
            'empty' => [''],
            'named color' => ['red'],
            'rgb()' => ['rgb(13, 110, 253)'],
            'var()' => ['var(--bs-primary)'],
            'missing hash' => ['0d6efd'],
            'wrong length' => ['#12345'],
            'non-hex digits' => ['#gggggg'],
            'integer' => [255],
            'array' => [['#0d6efd']],
            'css injection' => ['#fff; } body { background: url(https://evil.test/x) } .x {'],
            'markup injection' => ['#fff</style><script>alert(1)</script>'],
        ];
    }

    public function test_invalid_colors_produce_no_css(): void
    {
        Config::set('adminlte.primary_color', '#fff</style><script>alert(1)</script>');
        Config::set('adminlte.secondary_color', '#fff</style><script>alert(1)</script>');
        Config::set('adminlte.sidebar_color', 'rebeccapurple');

        $this->assertSame('', ThemeColors::styles());
    }

    public function test_primary_color_matches_bootstraps_compiled_button_variant(): void
    {
        // Feeding in Bootstrap's own $primary must reproduce the shades
        // Bootstrap ships, which is what keeps the override invisible until
        // someone actually picks a different colour.
        Config::set('adminlte.primary_color', '#0d6efd');

        $css = ThemeColors::styles();

        $this->assertStringContainsString('--bs-primary: #0d6efd;', $css);
        $this->assertStringContainsString('--bs-primary-rgb: 13, 110, 253;', $css);
        $this->assertStringContainsString('--bs-btn-color: #ffffff;', $css);
        $this->assertStringContainsString('--bs-btn-hover-bg: #0b5ed7;', $css);
        $this->assertStringContainsString('--bs-btn-hover-border-color: #0a58ca;', $css);
        $this->assertStringContainsString('--bs-btn-active-bg: #0a58ca;', $css);
        $this->assertStringContainsString('--bs-btn-active-border-color: #0a53be;', $css);
        $this->assertStringContainsString('--bs-link-hover-color: #0a58ca;', $css);
    }

    public function test_button_text_flips_to_black_on_light_backgrounds(): void
    {
        Config::set('adminlte.primary_color', '#ffc107');

        $this->assertStringContainsString('--bs-btn-color: #000000;', ThemeColors::styles());
    }

    public function test_secondary_color_matches_bootstraps_compiled_button_variant(): void
    {
        Config::set('adminlte.secondary_color', '#6c757d');

        $css = ThemeColors::styles();

        $this->assertStringContainsString('--bs-secondary: #6c757d;', $css);
        $this->assertStringContainsString('--bs-secondary-rgb: 108, 117, 125;', $css);
        $this->assertMatchesRegularExpression('/\.btn-secondary \{[^}]*--bs-btn-color: #ffffff;[^}]*--bs-btn-hover-bg: #5c636a;[^}]*--bs-btn-hover-border-color: #565e64;[^}]*--bs-btn-active-bg: #565e64;[^}]*--bs-btn-active-border-color: #51585e;/s', $css);
        $this->assertMatchesRegularExpression('/\.btn-outline-secondary \{[^}]*--bs-btn-color: #6c757d;[^}]*--bs-btn-hover-bg: #6c757d;[^}]*--bs-btn-active-bg: #6c757d;[^}]*--bs-btn-disabled-color: #6c757d;/s', $css);
        $this->assertStringNotContainsString('--bs-primary:', $css);
        $this->assertStringNotContainsString('--bs-link-color:', $css);
        $this->assertStringNotContainsString('--bs-secondary-bg:', $css);
    }

    public function test_secondary_color_is_independent_of_primary_and_sidebar(): void
    {
        Config::set('adminlte.primary_color', '#123456');
        Config::set('adminlte.secondary_color', '#ffc107');
        Config::set('adminlte.sidebar_color', '#abc');

        $css = ThemeColors::styles();

        $this->assertStringContainsString('--bs-primary: #123456;', $css);
        $this->assertStringContainsString('--bs-link-color: #123456;', $css);
        $this->assertStringContainsString('--bs-secondary: #ffc107;', $css);
        $this->assertMatchesRegularExpression('/\.btn-secondary \{\s*--bs-btn-color: #000000;/', $css);
        $this->assertMatchesRegularExpression('/\.app-sidebar \{\s*--bs-secondary-bg: #aabbcc;/', $css);
    }

    public function test_surface_colors_target_their_own_regions(): void
    {
        Config::set('adminlte.sidebar_color', '#343a40');
        Config::set('adminlte.navbar_color', '#ffffff');
        Config::set('adminlte.footer_color', '#f8f9fa');

        $css = ThemeColors::styles();

        $this->assertMatchesRegularExpression(
            '/\.app-sidebar \{\s*--bs-secondary-bg: #343a40;\s*--bs-secondary-bg-rgb: 52, 58, 64;/',
            $css
        );
        $this->assertMatchesRegularExpression(
            '/\.app-header \{\s*--bs-body-bg: #ffffff;\s*--bs-body-bg-rgb: 255, 255, 255;/',
            $css
        );
        $this->assertMatchesRegularExpression(
            '/\.app-footer \{\s*--bs-body-bg: #f8f9fa;\s*--bs-body-bg-rgb: 248, 249, 250;/',
            $css
        );

        // Untouched keys must not leak a block at all.
        $this->assertStringNotContainsString('--bs-primary:', $css);
    }

    public function test_layout_renders_the_style_block_only_when_configured(): void
    {
        $this->assertSame('', trim(view('adminlte::partials.theme-colors')->render()));

        Config::set('adminlte.primary_color', '#6610f2');
        Config::set('adminlte.secondary_color', '#abc');

        $rendered = view('adminlte::partials.theme-colors')->render();

        $this->assertStringContainsString('<style id="adminlte-theme-colors">', $rendered);
        $this->assertStringContainsString('--bs-primary: #6610f2;', $rendered);
        $this->assertStringContainsString('--bs-secondary: #aabbcc;', $rendered);
    }

    public function test_layout_renders_a_style_block_for_secondary_alone(): void
    {
        Config::set('adminlte.secondary_color', '#abc');

        $rendered = view('adminlte::partials.theme-colors')->render();

        $this->assertStringContainsString('<style id="adminlte-theme-colors">', $rendered);
        $this->assertStringContainsString('--bs-secondary: #aabbcc;', $rendered);
        $this->assertStringNotContainsString('--bs-primary:', $rendered);
    }

    public function test_theme_generator_seeds_its_pickers_from_config(): void
    {
        $this->withoutVite();

        Config::set('adminlte.primary_color', '#6610f2');
        Config::set('adminlte.secondary_color', '#abc');
        Config::set('adminlte.sidebar_theme', 'light');

        $view = view('adminlte::demo.theme-generator')->render();

        // Regression guard for the duplicate-attribute bug: `value="…"` used to
        // be passed through as a stray attribute after the component had already
        // emitted its own, so the browser kept the first one and every picker
        // rendered Bootstrap blue no matter what was configured.
        $this->assertSame(
            1,
            preg_match_all('/name="primary_color"[^>]*value="#6610f2"/', $view),
        );
        $this->assertSame(
            0,
            preg_match_all('/<input[^>]*value="[^"]*"[^>]*value="/', $view),
        );

        $this->assertSame(1, preg_match_all('/name="secondary_color"[^>]*value="#aabbcc"/', $view));
        $this->assertStringContainsString("'secondary_color' => '\${colors.secondary_color}'", $view);
        $this->assertStringContainsString('<option value="light" selected>Light</option>', $view);
    }

    public function test_theme_generator_defaults_secondary_to_bootstraps_color(): void
    {
        $this->withoutVite();

        $view = view('adminlte::demo.theme-generator')->render();

        $this->assertSame(1, preg_match_all('/name="secondary_color"[^>]*value="#6c757d"/', $view));
    }
}
