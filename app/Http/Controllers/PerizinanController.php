<?php

namespace App\Http\Controllers;

use App\Models\Perizinan;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PerizinanController extends Controller
{
    // 1. TAMPILKAN DAFTAR IZIN (INDEX)
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'wali') {
            // Wali hanya melihat izin anak-anaknya sendiri
            $santriIds = Santri::where('user_id', $user->id)->pluck('id');
            $perizinans = Perizinan::whereIn('santri_id', $santriIds)->with('santri')->latest()->get();
        } else {
            // Admin, Ustadz, dan Kamtib melihat semua data perizinan
            $perizinans = Perizinan::with(['santri', 'user'])->latest()->get();
        }

        return view('perizinan.index', compact('perizinans'));
    }

    // 2. TAMPILKAN FORM BUAT IZIN (KHUSUS WALI)
    public function create()
    {
        // Ambil data anak dari wali yang sedang login
        $santris = Santri::where('user_id', Auth::id())->get();
        return view('perizinan.create', compact('santris'));
    }

    // 3. PROSES SIMPAN DATA IZIN
    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required',
            'tgl_jemput' => 'required|date',
            'jam_jemput' => 'required',
            'tgl_kembali' => 'required|date',
            'jam_kembali' => 'required',
            'alasan' => 'required|string',
        ]);

        Perizinan::create([
            'santri_id' => $request->santri_id,
            'user_id' => Auth::id(),
            'tgl_jemput' => $request->tgl_jemput,
            'jam_jemput' => $request->jam_jemput,
            'tgl_kembali' => $request->tgl_kembali,
            'jam_kembali' => $request->jam_kembali,
            'alasan' => $request->alasan,
            'status' => 'pending',
            'token_gatepass' => strtoupper(Str::random(6)),
        ]);

        // KEMBALI KE DAFTAR IZIN SETELAH SIMPAN
        return redirect()->route('perizinan.index')->with('success', 'Pengajuan izin santri berhasil dikirim!');
    }

    // 4. PROSES PERSETUJUAN (ADMIN / USTADZ)
    public function approve(Request $request, $id)
    {
        $perizinan = Perizinan::findOrFail($id);
        $perizinan->update([
            'status' => $request->status // approved atau rejected
        ]);

        return redirect()->route('perizinan.index')->with('success', 'Status perizinan berhasil diperbarui!');
    }

    // 5. CATAT KELUAR (KAMTIB / ADMIN)
    public function checkOut($id)
    {
        $perizinan = Perizinan::findOrFail($id);
        $perizinan->update(['status' => 'out']);

        return redirect()->route('perizinan.index')->with('success', 'Santri telah dikonfirmasi KELUAR dari pondok.');
    }

    // 6. CATAT KEMBALI (KAMTIB / ADMIN)
    public function checkIn($id)
    {
        $perizinan = Perizinan::findOrFail($id);
        $perizinan->update(['status' => 'returned']);

        return redirect()->route('perizinan.index')->with('success', 'Santri telah dikonfirmasi KEMBALI ke pondok.');
    }
}