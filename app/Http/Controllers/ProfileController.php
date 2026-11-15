<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Transaksi;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        $request->user()->save();
        ActivityLogger::record("Memperbarui profil akun {$request->user()->username}.");

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        $hasRelatedRecords = Kendaraan::where('id_user', $user->id)->exists()
            || LogAktivitas::where('id_user', $user->id)->exists()
            || Transaksi::where('id_user', $user->id)->exists();

        if ($hasRelatedRecords) {
            return back()->withErrors([
                'password' => 'Akun tidak dapat dihapus karena masih memiliki data kendaraan, transaksi, atau log aktivitas.',
            ], 'userDeletion');
        }

        if ($user->role === 'admin'
            && User::where('role', 'admin')->where('status_aktif', true)->count() <= 1) {
            return back()->withErrors([
                'password' => 'Admin aktif terakhir tidak dapat menghapus akunnya sendiri.',
            ], 'userDeletion');
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
