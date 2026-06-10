<?php

namespace ColorlibHQ\AdminLte\Tests;

/**
 * Regression tests asserting that component output escapes hostile input.
 * These render components with <script> payloads and dangerous URL schemes
 * and assert nothing executable survives.
 */
class EscapingTest extends TestCase
{
    private const PAYLOAD = '<script>alert(1)</script>';

    public function test_card_escapes_title(): void
    {
        $html = (string) $this->blade(
            '<x-adminlte-card :title="$title">Body</x-adminlte-card>',
            ['title' => self::PAYLOAD]
        );

        $this->assertStringNotContainsString(self::PAYLOAD, $html);
        $this->assertStringContainsString('&lt;script&gt;', $html);
    }

    public function test_input_escapes_label_and_value(): void
    {
        $html = (string) $this->blade(
            '<x-adminlte-input name="n" :label="$label" :value="$value" />',
            ['label' => self::PAYLOAD, 'value' => '" onmouseover="alert(1)']
        );

        $this->assertStringNotContainsString(self::PAYLOAD, $html);
        $this->assertStringNotContainsString('onmouseover="alert(1)"', $html);
    }

    public function test_profile_card_blocks_javascript_urls(): void
    {
        $html = (string) $this->blade(
            '<x-adminlte-profile-card name="User" :socials="$socials" />',
            ['socials' => [
                ['url' => 'javascript:alert(1)', 'icon' => 'bi bi-x'],
                ['url' => 'data:text/html,evil', 'icon' => 'bi bi-x'],
                ['url' => 'https://example.com/ok', 'icon' => 'bi bi-check'],
                ['url' => 'mailto:user@example.com', 'icon' => 'bi bi-envelope'],
            ]]
        );

        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertStringNotContainsString('data:text/html', $html);
        $this->assertStringContainsString('https://example.com/ok', $html);
        $this->assertStringContainsString('mailto:user@example.com', $html);
    }

    public function test_sortable_options_json_is_attribute_safe(): void
    {
        $html = (string) $this->blade(
            '<x-adminlte-sortable :options="$options">Items</x-adminlte-sortable>',
            ['options' => ['handle' => '"><script>alert(1)</script>']]
        );

        $this->assertStringNotContainsString('<script>alert(1)</script>', $html);
    }

    public function test_small_box_escapes_text(): void
    {
        $html = (string) $this->blade(
            '<x-adminlte-small-box :title="$t" :text="$t" theme="info" />',
            ['t' => self::PAYLOAD]
        );

        $this->assertStringNotContainsString(self::PAYLOAD, $html);
    }
}
