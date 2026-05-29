@extends('adminlte::page')

@section('title', __('adminlte.pricing'))

@section('content_header')
    <h1 class="m-0">{{ __('adminlte.pricing') }}</h1>
@stop

@section('content')
    @php
        $plans = [
            ['name' => 'Basic', 'price' => 9, 'theme' => 'secondary', 'featured' => false,
             'features' => ['1 User', '10 Projects', '2GB Storage', 'Email Support']],
            ['name' => 'Pro', 'price' => 29, 'theme' => 'primary', 'featured' => true,
             'features' => ['5 Users', 'Unlimited Projects', '50GB Storage', 'Priority Support']],
            ['name' => 'Enterprise', 'price' => 99, 'theme' => 'dark', 'featured' => false,
             'features' => ['Unlimited Users', 'Unlimited Projects', '1TB Storage', '24/7 Support']],
        ];
    @endphp

    <div class="row justify-content-center">
        @foreach ($plans as $plan)
            <div class="col-md-4 mb-4">
                <div class="card h-100 {{ $plan['featured'] ? 'border-primary shadow' : '' }}">
                    <div class="card-header text-center bg-{{ $plan['theme'] }} text-white">
                        <h4 class="my-2">{{ $plan['name'] }}</h4>
                    </div>
                    <div class="card-body text-center">
                        <h1 class="card-title">${{ $plan['price'] }}<small class="text-muted fs-6">/{{ __('adminlte.month') }}</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            @foreach ($plan['features'] as $feature)
                                <li class="py-1"><i class="bi bi-check-lg text-success me-1"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <a href="#" class="btn btn-{{ $plan['featured'] ? 'primary' : 'outline-'.$plan['theme'] }} w-100">
                            {{ __('adminlte.choose_plan') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
