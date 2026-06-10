@if (session()->has('impersonator_id') && \Illuminate\Support\Facades\Route::has('adminlte.impersonate.stop'))
    <div class="alert alert-warning border-0 rounded-0 mb-0 d-flex justify-content-between align-items-center px-3 py-2">
        <span>
            <i class="bi bi-incognito me-1" aria-hidden="true"></i>
            {{ __('adminlte.impersonating', ['name' => auth()->user()?->name]) }}
        </span>
        <a href="{{ route('adminlte.impersonate.stop') }}" class="btn btn-sm btn-dark">
            <i class="bi bi-box-arrow-left me-1" aria-hidden="true"></i> {{ __('adminlte.leave_impersonation') }}
        </a>
    </div>
@endif
