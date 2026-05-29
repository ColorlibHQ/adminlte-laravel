<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('adminlte.settings.index', ['user' => Auth::user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'locale' => ['nullable', 'string', 'max:5'],
        ]);

        Auth::user()->update(['name' => $data['name']]);

        if (! empty($data['locale'])) {
            session(['locale' => $data['locale']]);
        }

        return redirect()->route('adminlte.settings.edit')
            ->with('status', __('adminlte.settings_saved'));
    }
}
