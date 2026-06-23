<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class WaliRegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register-wali');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nis'      => ['required', 'string', 'exists:santris,nis'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'no_hp'    => ['nullable', 'string', 'max:20'],
        ]);

        $santri = Santri::where('nis', $request->nis)->first();

        abort_if($santri->user_id !== null, 422, 'NIS ini sudah terdaftar dengan akun wali lain.');

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'wali',
            'no_hp'    => $request->no_hp,
        ]);

        $santri->update(['user_id' => $user->id]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil, akun terhubung dengan data santri: ' . $santri->nama_santri);
    }
}