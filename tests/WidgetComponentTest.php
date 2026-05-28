<?php

namespace ColorlibHQ\AdminLte\Tests;

class WidgetComponentTest extends TestCase
{
    public function test_timeline_component_renders(): void
    {
        $html = $this->blade(
            '<x-adminlte-timeline :items="[
                [\'title\' => \'Event 1\', \'body\' => \'Description\', \'icon\' => \'bi-check\', \'icon_bg\' => \'bg-success\'],
            ]" />'
        );

        $html->assertSee('timeline timeline-inverse', false);
        $html->assertSee('Event 1');
        $html->assertSee('Description');
    }

    public function test_progress_group_renders_label_and_bar(): void
    {
        $html = $this->blade(
            '<x-adminlte-progress-group label="January" :value="75" color="primary" />'
        );

        $html->assertSee('January');
        $html->assertSee('75%');
        $html->assertSee('progress-bar bg-primary', false);
    }

    public function test_ratings_component_renders_stars(): void
    {
        $html = $this->blade(
            '<x-adminlte-ratings :value="4" :max="5" />'
        );

        $html->assertSee('bi-star-fill', false);
        $html->assertSee('bi-star', false);
    }

    public function test_profile_card_renders_user_info(): void
    {
        $html = $this->blade(
            '<x-adminlte-profile-card name="John Doe" title="Developer" />'
        );

        $html->assertSee('card card-primary card-outline', false);
        $html->assertSee('John Doe');
        $html->assertSee('Developer');
    }

    public function test_description_block_renders_title(): void
    {
        $html = $this->blade(
            '<x-adminlte-description-block title="Project Info" text="Description" />'
        );

        $html->assertSee('description-block', false);
        $html->assertSee('Project Info');
        $html->assertSee('Description');
    }

    public function test_nav_notifications_shows_badge(): void
    {
        $html = $this->blade(
            '<x-adminlte-nav-notifications :notifications="[
                [\'title\' => \'New message\', \'icon\' => \'bi-envelope\'],
            ]" />'
        );

        $html->assertSee('badge', false);
        $html->assertSee('New message');
    }

    public function test_nav_messages_renders_dropdown(): void
    {
        $html = $this->blade(
            '<x-adminlte-nav-messages :messages="[
                [\'from\' => \'John\', \'text\' => \'Hello\'],
            ]" />'
        );

        $html->assertSee('dropdown-menu', false);
        $html->assertSee('John');
        $html->assertSee('Hello');
    }

    public function test_nav_tasks_shows_progress(): void
    {
        $html = $this->blade(
            '<x-adminlte-nav-tasks :tasks="[
                [\'title\' => \'Task 1\', \'progress\' => 50],
            ]" />'
        );

        $html->assertSee('Task 1');
        $html->assertSee('dropdown-footer', false);
    }
}
