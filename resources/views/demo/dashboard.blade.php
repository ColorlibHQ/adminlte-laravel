@extends('adminlte::master', ['title' => 'AdminLTE 4 — Demo Dashboard'])

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    {{-- Info boxes --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <x-adminlte-small-box title="150" icon="bi-users" color="primary">
                Total Users
            </x-adminlte-small-box>
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="2,542" icon="bi-cart" color="success">
                Total Sales
            </x-adminlte-small-box>
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="85" icon="bi-percent" color="warning">
                Conversion Rate
            </x-adminlte-small-box>
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="23" icon="bi-exclamation-triangle" color="danger">
                Failed Orders
            </x-adminlte-small-box>
        </div>
    </div>

    <div class="row">
        {{-- Stats column --}}
        <div class="col-md-4">
            {{-- Progress groups --}}
            <x-adminlte-card title="Sales Overview">
                <x-adminlte-progress-group label="January" :value="50" color="primary" />
                <x-adminlte-progress-group label="February" :value="75" color="success" />
                <x-adminlte-progress-group label="March" :value="45" color="warning" />
                <x-adminlte-progress-group label="April" :value="90" color="info" />
            </x-adminlte-card>

            {{-- Ratings --}}
            <x-adminlte-card title="Customer Ratings">
                <div class="mb-3">
                    <h6>Product A</h6>
                    <x-adminlte-ratings :value="5" />
                </div>
                <div class="mb-3">
                    <h6>Product B</h6>
                    <x-adminlte-ratings :value="4" />
                </div>
                <div class="mb-3">
                    <h6>Product C</h6>
                    <x-adminlte-ratings :value="3" />
                </div>
            </x-adminlte-card>
        </div>

        {{-- Timeline --}}
        <div class="col-md-4">
            <x-adminlte-card title="Recent Activity">
                <x-adminlte-timeline :items="[
                    [
                        'title' => 'New user registered',
                        'body' => 'John Doe signed up',
                        'icon' => 'bi-person-plus',
                        'icon_bg' => 'bg-success',
                        'time' => '2 hours ago',
                    ],
                    [
                        'title' => 'Order placed',
                        'body' => 'Order #12345 was confirmed',
                        'icon' => 'bi-cart-check',
                        'icon_bg' => 'bg-primary',
                        'time' => '4 hours ago',
                    ],
                    [
                        'title' => 'Payment received',
                        'body' => 'Invoice INV-001 paid',
                        'icon' => 'bi-check-circle',
                        'icon_bg' => 'bg-warning',
                        'time' => '1 day ago',
                    ],
                ]" />
            </x-adminlte-card>
        </div>

        {{-- Profile cards --}}
        <div class="col-md-4">
            <x-adminlte-profile-card
                name="John Doe"
                title="Full Stack Developer"
                description="Web Developer | Open Source Enthusiast"
                image="https://api.dicebear.com/7.x/avataaars/svg?seed=John"
                :socials="[
                    ['url' => '#', 'icon' => 'bi-github', 'color' => 'dark'],
                    ['url' => '#', 'icon' => 'bi-twitter', 'color' => 'info'],
                    ['url' => '#', 'icon' => 'bi-linkedin', 'color' => 'primary'],
                ]"
            />

            <x-adminlte-card title="Description Block">
                <x-adminlte-description-block
                    title="Project Info"
                    text="Lorem ipsum dolor sit amet"
                    :items="[
                        'Status' => 'Active',
                        'Users' => '150',
                        'Version' => '3.0.0',
                    ]"
                />
            </x-adminlte-card>
        </div>
    </div>

    <div class="row mt-4">
        {{-- Demo form inputs --}}
        <div class="col-md-6">
            <x-adminlte-card title="Form Inputs Demo">
                <form>
                    <x-adminlte-input
                        name="username"
                        label="Username"
                        placeholder="Enter username"
                    />

                    <x-adminlte-input-tom-select
                        name="category"
                        label="Select Category"
                        placeholder="Choose a category"
                        :options="[
                            'tech' => 'Technology',
                            'business' => 'Business',
                            'health' => 'Health',
                            'education' => 'Education',
                        ]"
                    />

                    <x-adminlte-input-flatpickr
                        name="birthdate"
                        label="Birth Date"
                        type="date"
                        placeholder="Select date"
                    />

                    <x-adminlte-editor
                        name="description"
                        label="Description"
                        placeholder="Enter description"
                    />

                    <x-adminlte-button type="submit" class="btn-primary">
                        Submit
                    </x-adminlte-button>
                </form>
            </x-adminlte-card>
        </div>

        {{-- Alert variants --}}
        <div class="col-md-6">
            <x-adminlte-alert type="primary" title="Primary Alert">
                This is a primary alert message.
            </x-adminlte-alert>

            <x-adminlte-alert type="success" title="Success Alert">
                Your action was completed successfully!
            </x-adminlte-alert>

            <x-adminlte-alert type="warning" title="Warning Alert">
                Please review this information carefully.
            </x-adminlte-alert>

            <x-adminlte-alert type="danger" title="Danger Alert">
                An error occurred. Please try again.
            </x-adminlte-alert>
        </div>
    </div>
@endsection
