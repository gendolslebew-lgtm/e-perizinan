<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerizinanController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// 1. HALAMAN FORM LOGIN ASLI (Bisa diakses online)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// 2. PROSES LOGIKA LOGIN
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password yang kamu masukkan salah.',
    ])->onlyInput('email');
});

// 3. RUTE LOGOUT ASLI
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// 4. HALAMAN UTAMA DIALIRKAN KE LOGIN
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// SEMUA RUTE PROTEKSI AUTH (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/perizinan', [PerizinanController::class, 'index'])->name('perizinan.index');

    // Khusus Wali
    Route::middleware(['role:wali'])->group(function () {
        Route::get('/perizinan/create', [PerizinanController::class, 'create'])->name('perizinan.create');
        Route::post('/perizinan/store', [PerizinanController::class, 'store'])->name('perizinan.store');
    });

    // Khusus Admin / Ustadz
    Route::middleware(['role:admin,ustadz'])->group(function () {
        Route::post('/perizinan/{id}/approve', [PerizinanController::class, 'approve'])->name('perizinan.approve');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    // Khusus kamtib
    Route::middleware(['role:kamtib,admin'])->group(function () {
        Route::post('/perizinan/{id}/check-out', [PerizinanController::class, 'checkOut'])->name('perizinan.checkOut');
        Route::post('/perizinan/{id}/check-in', [PerizinanController::class, 'checkIn'])->name('perizinan.checkIn');
    });
});