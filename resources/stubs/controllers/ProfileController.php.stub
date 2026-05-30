<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLte\UpdatePasswordRequest;
use App\Http\Requests\AdminLte\UpdateProfileRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        return view('adminlte.profile.index', [
            'user' => $request->user(),
            'sessions' => $this->sessions($request),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Re-trigger email verification if the address changed.
        if ($user instanceof MustVerifyEmail && isset($data['email']) && $data['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        $user->fill($data);
        $user->save();

        if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('adminlte.profile.show')
            ->with('status', __('adminlte.profile_updated'));
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated()['password']),
        ]);

        return redirect()->route('adminlte.profile.show')
            ->with('status', __('adminlte.password_updated'));
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Set directly (rather than mass-assign) so this works without adding
        // 'avatar' to the User model's $fillable.
        $user->avatar = $request->file('avatar')->store('avatars', 'public');
        $user->save();

        return redirect()->route('adminlte.profile.show')
            ->with('status', __('adminlte.avatar_updated'));
    }

    public function logoutOtherDevices(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'current_password']]);

        Auth::logoutOtherDevices($request->input('password'));

        return redirect()->route('adminlte.profile.show')
            ->with('status', __('adminlte.other_sessions_logged_out'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'current_password']]);

        $user = $request->user();

        Auth::logout();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * The user's active sessions (only when using the database session driver).
     *
     * @return array<int, object>
     */
    protected function sessions(Request $request): array
    {
        if (config('session.driver') !== 'database') {
            return [];
        }

        return DB::table('sessions')
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->orderByDesc('last_activity')
            ->get()
            ->map(fn ($session) => (object) [
                'agent' => $session->user_agent,
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp((int) $session->last_activity)->diffForHumans(),
            ])
            ->all();
    }
}
