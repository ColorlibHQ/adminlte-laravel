<?php

namespace ColorlibHQ\AdminLte\Tests;

class LayoutTest extends TestCase
{
    public function test_master_layout_renders_basic_structure(): void
    {
        $html = $this->blade(
            "@extends('adminlte::master')
             @section('content')
             <p>Test</p>
             @endsection"
        );

        $html->assertSee('app-wrapper', false);
        $html->assertSee('app-header', false);
        $html->assertSee('app-main', false);
        $html->assertSee('Test');
    }

    public function test_page_layout_renders_with_content(): void
    {
        $html = $this->blade(
            "@extends('adminlte::page')
             @section('content')
             <p>Page content</p>
             @endsection"
        );

        $html->assertSee('Page content');
    }

    public function test_auth_layout_renders_login_box(): void
    {
        $html = $this->blade(
            "@extends('adminlte::auth.auth-master', ['authType' => 'login'])
             @section('auth_body')
             <p>Login form</p>
             @endsection"
        );

        $html->assertSee('login-box', false);
    }

    public function test_master_layout_respects_rtl_config(): void
    {
        config()->set('adminlte.layout_rtl', true);

        $html = $this->blade(
            "@extends('adminlte::master')
             @section('content')Test@endsection"
        );

        $html->assertSee('dir="rtl"', false);
    }

    public function test_master_layout_defaults_to_ltr(): void
    {
        config()->set('adminlte.layout_rtl', false);

        $html = $this->blade(
            "@extends('adminlte::master')
             @section('content')Test@endsection"
        );

        $html->assertSee('dir="ltr"', false);
    }

    public function test_master_layout_includes_navbar(): void
    {
        $html = $this->blade(
            "@extends('adminlte::master')
             @section('content')Test@endsection"
        );

        $html->assertSee('app-header', false);
    }

    public function test_master_layout_includes_sidebar(): void
    {
        $html = $this->blade(
            "@extends('adminlte::master')
             @section('content')Test@endsection"
        );

        $html->assertSee('app-sidebar', false);
    }

    public function test_master_layout_includes_footer(): void
    {
        $html = $this->blade(
            "@extends('adminlte::master')
             @section('content')Test@endsection"
        );

        $html->assertSee('app-footer', false);
    }
}
