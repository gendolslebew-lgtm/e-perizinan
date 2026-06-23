<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Perizinan::with(['santri', 'user']);

        // Filter berdasarkan tanggal jika diisi
        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tgl_jemput', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        // Filter berdasarkan status jika diisi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporans = $query->latest()->get();

        return view('laporan.index', compact('laporans'));
    }
}