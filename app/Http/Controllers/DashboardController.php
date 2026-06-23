<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\Santri;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $stats = [];

        if ($user->role === 'wali') {
            // Ambil ID santri yang dimiliki oleh wali ini
            $santriIds = Santri::where('user_id', $user->id)->pluck('id');

            $stats['total_izin'] = Perizinan::whereIn('santri_id', $santriIds)->count();
            $stats['pending']    = Perizinan::whereIn('santri_id', $santriIds)->where('status', 'pending')->count();
            $stats['approved']   = Perizinan::whereIn('santri_id', $santriIds)->where('status', 'approved')->count();
            $stats['di_luar']    = Perizinan::whereIn('santri_id', $santriIds)->where('status', 'out')->count();
        } else {
            // Statistik untuk Admin, Ustadz, dan Satpam
            $stats['total_santri'] = Santri::count();
            $stats['pending']      = Perizinan::where('status', 'pending')->count();
            $stats['di_luar']       = Perizinan::where('status', 'out')->count();
            $stats['selesai']      = Perizinan::where('status', 'returned')->count();
        }

        return view('dashboard', compact('stats'));
    }
}