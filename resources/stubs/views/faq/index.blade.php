@extends('adminlte::page')

@section('title', __('adminlte.faq'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.faq') }}</h1>
@stop

@section('content')
    @php
        $faqs = [
            ['q' => 'How do I install the package?', 'a' => 'Run composer require colorlibhq/adminlte-laravel, then php artisan adminlte:install.'],
            ['q' => 'How do I scaffold a section?', 'a' => 'Run php artisan adminlte:scaffold mailbox --seed to generate the migration, model, controller, routes and demo data.'],
            ['q' => 'Can I customize the components?', 'a' => 'Yes. Publish the views with php artisan adminlte:install and edit them under resources/views/vendor/adminlte.'],
            ['q' => 'Is RTL supported?', 'a' => 'Yes. Set layout_rtl to true in config/adminlte.php to load the right-to-left stylesheet.'],
        ];
    @endphp

    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-adminlte-card icon="bi bi-question-circle" title="{{ __('adminlte.frequently_asked') }}">
                <x-adminlte-accordion id="faq-accordion">
                    @foreach ($faqs as $i => $faq)
                        <x-adminlte-accordion-item :title="$faq['q']" parent="faq-accordion" :expanded="$i === 0">
                            {{ $faq['a'] }}
                        </x-adminlte-accordion-item>
                    @endforeach
                </x-adminlte-accordion>
            </x-adminlte-card>
        </div>
    </div>
@stop
