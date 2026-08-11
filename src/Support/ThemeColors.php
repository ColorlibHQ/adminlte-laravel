<?php

namespace ColorlibHQ\AdminLte\Support;

/**
 * Turns the `*_color` config keys into a block of CSS custom-property
 * overrides that is injected into the layout `<head>`.
 *
 * AdminLTE 4 and Bootstrap 5.3 already express every surface as a custom
 * property, so recolouring the chrome is a matter of re-pointing a handful of
 * variables rather than shipping a second stylesheet:
 *
 * | Config key      | What it repaints | Variables                        |
 * | --------------- | ---------------- | -------------------------------- |
 * | `primary_color` | Brand colour     | `--bs-primary*`, `--bs-link-*`,  |
 * |                 |                  | `.btn-primary`, `.btn-outline-…` |
 * | `sidebar_color` | `.app-sidebar`   | `--bs-secondary-bg*`             |
 * | `navbar_color`  | `.app-header`    | `--bs-body-bg*`                  |
 * | `footer_color`  | `.app-footer`    | `--bs-body-bg*`                  |
 *
 * SECURITY: the output is rendered unescaped inside a `<style>` element, so
 * every value that reaches it must be provably safe. Colours are matched
 * against a strict `#rgb`/`#rrggbb` pattern and anything else is dropped —
 * the emitted string can therefore only ever contain hex digits, integers and
 * the selectors hardcoded below. Do not relax {@see self::HEX_PATTERN}
 * (to accept `rgb()`, `var()` or named colours) without escaping the value.
 *
 * Buttons need explicit treatment because Bootstrap compiles `.btn-primary`
 * from Sass literals rather than from `--bs-primary`, so hover/active shades
 * are recomputed here with Bootstrap's own `shade-color()` weights.
 */
class ThemeColors
{
    private const HEX_PATTERN = '/^#(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/';

    /**
     * Bootstrap's `shade-color()` weights for the button/link states, as the
     * fraction of the base colour that survives the mix with black.
     */
    private const SHADE_HOVER_BG = 0.85;

    private const SHADE_HOVER_BORDER = 0.80;

    private const SHADE_ACTIVE_BG = 0.80;

    private const SHADE_ACTIVE_BORDER = 0.75;

    /** Bootstrap's $min-contrast-ratio. */
    private const MIN_CONTRAST_RATIO = 4.5;

    /**
     * The CSS for the currently configured colours, or an empty string when no
     * colour is set (the default) — in which case the layout emits no `<style>`
     * element at all and the stock AdminLTE palette applies untouched.
     */
    public static function styles(): string
    {
        $blocks = array_filter([
            self::primaryBlocks(self::configured('primary_color')),
            self::surfaceBlock('.app-sidebar', '--bs-secondary-bg', self::configured('sidebar_color')),
            self::surfaceBlock('.app-header', '--bs-body-bg', self::configured('navbar_color')),
            self::surfaceBlock('.app-footer', '--bs-body-bg', self::configured('footer_color')),
        ]);

        return implode("\n", $blocks);
    }

    /**
     * Normalize a config value to a safe `#rrggbb` string, or null if it is
     * unset, not a string, or not a valid hex colour.
     */
    public static function normalize(mixed $color): ?string
    {
        if (! is_string($color)) {
            return null;
        }

        $color = trim($color);

        if (preg_match(self::HEX_PATTERN, $color) !== 1) {
            return null;
        }

        // Expand the #abc shorthand so downstream maths has one shape to handle.
        if (strlen($color) === 4) {
            $color = '#'.$color[1].$color[1].$color[2].$color[2].$color[3].$color[3];
        }

        return strtolower($color);
    }

    /**
     * The `r, g, b` triplet Bootstrap's `*-rgb` variables expect.
     */
    public static function rgb(string $hex): string
    {
        [$r, $g, $b] = self::channels($hex);

        return "$r, $g, $b";
    }

    private static function configured(string $key): ?string
    {
        return self::normalize(config("adminlte.$key"));
    }

    /**
     * Repoint a single surface (sidebar, navbar, footer). Both the plain and
     * the `-rgb` variable are emitted: AdminLTE uses `var(--bs-body-bg)`
     * directly for `.app-footer`, while the `.bg-body*` utility classes on the
     * navbar and sidebar compose `rgba(var(--bs-*-rgb), var(--bs-bg-opacity))`.
     */
    private static function surfaceBlock(string $selector, string $variable, ?string $color): ?string
    {
        if ($color === null) {
            return null;
        }

        return self::rule($selector, [
            $variable => $color,
            $variable.'-rgb' => self::rgb($color),
        ]);
    }

    /**
     * @return string|null CSS for the brand colour, spanning the theme
     *                     variables, links and both primary button variants.
     */
    private static function primaryBlocks(?string $color): ?string
    {
        if ($color === null) {
            return null;
        }

        $hoverBg = self::shade($color, self::SHADE_HOVER_BG);
        $hoverBorder = self::shade($color, self::SHADE_HOVER_BORDER);
        $activeBg = self::shade($color, self::SHADE_ACTIVE_BG);
        $activeBorder = self::shade($color, self::SHADE_ACTIVE_BORDER);
        $foreground = self::contrastColor($color);

        return implode("\n", [
            self::rule(':root, [data-bs-theme="light"], [data-bs-theme="dark"]', [
                '--bs-primary' => $color,
                '--bs-primary-rgb' => self::rgb($color),
                '--bs-link-color' => $color,
                '--bs-link-color-rgb' => self::rgb($color),
                '--bs-link-hover-color' => $hoverBorder,
                '--bs-link-hover-color-rgb' => self::rgb($hoverBorder),
            ]),
            self::rule('.btn-primary', [
                '--bs-btn-color' => $foreground,
                '--bs-btn-bg' => $color,
                '--bs-btn-border-color' => $color,
                '--bs-btn-hover-color' => $foreground,
                '--bs-btn-hover-bg' => $hoverBg,
                '--bs-btn-hover-border-color' => $hoverBorder,
                '--bs-btn-focus-shadow-rgb' => self::rgb($color),
                '--bs-btn-active-color' => $foreground,
                '--bs-btn-active-bg' => $activeBg,
                '--bs-btn-active-border-color' => $activeBorder,
                '--bs-btn-disabled-color' => $foreground,
                '--bs-btn-disabled-bg' => $color,
                '--bs-btn-disabled-border-color' => $color,
            ]),
            self::rule('.btn-outline-primary', [
                '--bs-btn-color' => $color,
                '--bs-btn-border-color' => $color,
                '--bs-btn-hover-color' => $foreground,
                '--bs-btn-hover-bg' => $color,
                '--bs-btn-hover-border-color' => $color,
                '--bs-btn-focus-shadow-rgb' => self::rgb($color),
                '--bs-btn-active-color' => $foreground,
                '--bs-btn-active-bg' => $color,
                '--bs-btn-active-border-color' => $color,
                '--bs-btn-disabled-color' => $color,
                '--bs-btn-disabled-border-color' => $color,
            ]),
        ]);
    }

    /**
     * @param  array<string, string>  $declarations
     */
    private static function rule(string $selector, array $declarations): string
    {
        $body = '';

        foreach ($declarations as $property => $value) {
            $body .= "    $property: $value;\n";
        }

        return "$selector {\n".$body.'}';
    }

    /**
     * Bootstrap's `shade-color()`: mix the colour with black, keeping
     * `$keep` of each channel.
     */
    private static function shade(string $hex, float $keep): string
    {
        [$r, $g, $b] = self::channels($hex);

        return sprintf(
            '#%02x%02x%02x',
            (int) round($r * $keep),
            (int) round($g * $keep),
            (int) round($b * $keep),
        );
    }

    /**
     * Black or white button text, following Bootstrap's `color-contrast()`
     * exactly: prefer white as soon as it clears $min-contrast-ratio, fall back
     * to black, and only compare ratios when neither clears the bar.
     *
     * "Prefer white" rather than "pick the higher ratio" matters more than it
     * looks — Bootstrap's own $primary (#0d6efd) contrasts 4.50:1 against white
     * and 4.67:1 against black, so picking the maximum would render every stock
     * primary button with black text instead of Bootstrap's white.
     */
    private static function contrastColor(string $hex): string
    {
        $luminance = self::relativeLuminance($hex);

        $onWhite = 1.05 / ($luminance + 0.05);
        $onBlack = ($luminance + 0.05) / 0.05;

        if ($onWhite > self::MIN_CONTRAST_RATIO) {
            return '#ffffff';
        }

        if ($onBlack > self::MIN_CONTRAST_RATIO) {
            return '#000000';
        }

        return $onWhite >= $onBlack ? '#ffffff' : '#000000';
    }

    private static function relativeLuminance(string $hex): float
    {
        $weights = [0.2126, 0.7152, 0.0722];
        $luminance = 0.0;

        foreach (self::channels($hex) as $index => $channel) {
            $value = $channel / 255;
            $value = $value <= 0.04045
                ? $value / 12.92
                : (($value + 0.055) / 1.055) ** 2.4;

            $luminance += $value * $weights[$index];
        }

        return $luminance;
    }

    /**
     * @return array{0: int, 1: int, 2: int}
     */
    private static function channels(string $hex): array
    {
        return [
            (int) hexdec(substr($hex, 1, 2)),
            (int) hexdec(substr($hex, 3, 2)),
            (int) hexdec(substr($hex, 5, 2)),
        ];
    }
}
