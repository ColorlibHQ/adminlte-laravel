<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Personal access token management (Laravel Sanctum). Requires Sanctum:
 *
 *     php artisan install:api
 *
 * which installs Sanctum, the personal_access_tokens migration, and routes/api.php.
 */
class ApiTokenController extends Controller
{
    public function index(Request $request): View
    {
        return view('adminlte.api-tokens.index', [
            'tokens' => $request->user()->tokens()->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'abilities' => ['nullable', 'array'],
            'abilities.*' => ['string'],
        ]);

        $token = $request->user()->createToken(
            $data['name'],
            $data['abilities'] ?? ['*'],
        );

        // The plaintext token is shown exactly once.
        return redirect()->route('adminlte.api-tokens.index')
            ->with('token_plain', $token->plainTextToken)
            ->with('status', __('adminlte.token_created'));
    }

    public function destroy(Request $request, string $tokenId): RedirectResponse
    {
        $request->user()->tokens()->whereKey($tokenId)->delete();

        return redirect()->route('adminlte.api-tokens.index')
            ->with('status', __('adminlte.token_revoked'));
    }
}
