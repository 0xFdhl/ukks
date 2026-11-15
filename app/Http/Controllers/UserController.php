<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Transaksi;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->filled('q'), fn ($query) => $query->where(
                fn ($search) => $search->where('nama_lengkap', 'like', '%'.$request->q.'%')
                    ->orWhere('username', 'like', '%'.$request->q.'%')
            ))
            ->orderBy('nama_lengkap')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create', ['user' => new User()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:users,username'],
            'role' => ['required', Rule::in(['admin', 'petugas', 'owner'])],
            'status_aktif' => ['required', 'boolean'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        unset($data['password_confirmation']);
        $user = User::create($data);
        ActivityLogger::record("Membuat akun {$user->username} dengan role {$user->role}.");

        return redirect()->route('admin.user.index')->with('success', 'Akun berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): RedirectResponse
    {
        return redirect()->route('admin.user.edit', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9._-]+$/', Rule::unique('users', 'username')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'petugas', 'owner'])],
            'status_aktif' => ['required', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($user->role === 'admin' && $user->status_aktif
            && ($data['role'] !== 'admin' || !$data['status_aktif'])
            && User::where('role', 'admin')->where('status_aktif', true)->count() <= 1) {
            return back()->withInput()->withErrors(['role' => 'Admin aktif terakhir tidak dapat dinonaktifkan atau diubah role-nya.']);
        }

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }
        unset($data['password_confirmation']);

        $user->update($data);
        ActivityLogger::record("Memperbarui akun {$user->username}.");

        return redirect()->route('admin.user.index')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        if ($user->role === 'admin' && $user->status_aktif
            && User::where('role', 'admin')->where('status_aktif', true)->count() <= 1) {
            return back()->with('error', 'Admin aktif terakhir tidak dapat dihapus.');
        }

        if (Transaksi::where('id_user', $user->id)->exists()
            || LogAktivitas::where('id_user', $user->id)->exists()
            || $user->transaksis()->exists()
            || $user->kendaraans()->exists()) {
            return back()->with('error', 'Akun masih dipakai pada transaksi, kendaraan, atau log sehingga tidak dapat dihapus.');
        }

        $username = $user->username;
        DB::transaction(function () use ($user, $username) {
            $user->delete();
            ActivityLogger::record("Menghapus akun {$username}.");
        });

        return redirect()->route('admin.user.index')->with('success', 'Akun berhasil dihapus.');
    }
}
