<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Perizinan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen font-sans text-slate-800 antialiased">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200/80 shadow-sm">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-600 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Dashboard
            </a>
            <div class="text-xs text-slate-500 font-medium">Pengguna Aktif: <strong class="text-slate-800">{{ Auth::user()->name }}</strong></div>
        </div>
    </nav>

    <main class="container mx-auto mt-8 px-6 pb-12">
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-black tracking-tight text-slate-900">Daftar Pengajuan Perizinan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pantau arus status perizinan santri aktif disini.</p>
            </div>
            @if(Auth::user()->role === 'wali')
                <a href="{{ route('perizinan.create') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-lg shadow-blue-500/20 transition duration-300 flex items-center gap-2 self-start sm:self-auto">
                    <i class="fa-solid fa-plus-circle"></i> Ajukan Izin Baru
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 mb-6 rounded-2xl flex items-center gap-3 shadow-sm animate-pulse">
                <i class="fa-solid fa-circle-check text-lg text-emerald-600"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 text-slate-500 uppercase text-[11px] font-bold tracking-wider border-b border-slate-100">
                            <th class="p-4 pl-6">Data Santri</th>
                            <th class="p-4">Alasan Keperluan</th>
                            <th class="p-4">Rencana Keluar</th>
                            <th class="p-4">Batas Kembali</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center pr-6">Kontrol / Akses Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600 text-sm divide-y divide-slate-100">
                        @forelse($perizinans as $izin)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4 pl-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center rounded-xl border border-slate-200">
                                            {{ strtoupper(substr($izin->santri->nama_santri, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-900">{{ $izin->santri->nama_santri }}</span>
                                            <span class="block text-[11px] text-slate-400 font-medium">NIS: {{ $izin->santri->nis }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 max-w-xs"><p class="text-slate-700 font-medium truncate">{{ $izin->alasan }}</p></td>
                                <td class="p-4">
                                    <span class="block font-semibold text-slate-700 text-xs">{{ \Carbon\Carbon::parse($izin->tgl_jemput)->format('d M Y') }}</span>
                                    <span class="block text-[11px] text-slate-400"><i class="fa-regular fa-clock mr-1"></i>{{ $izin->jam_jemput }} WIB</span>
                                </td>
                                <td class="p-4">
                                    <span class="block font-semibold text-slate-700 text-xs">{{ \Carbon\Carbon::parse($izin->tgl_kembali)->format('d M Y') }}</span>
                                    <span class="block text-[11px] text-slate-400"><i class="fa-regular fa-clock mr-1"></i>{{ $izin->jam_kembali }} WIB</span>
                                </td>
                                <td class="p-4">
                                    @if($izin->status === 'pending')
                                        <span class="bg-amber-50 text-amber-700 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wide border border-amber-200"><i class="fa-solid fa-spinner fa-spin mr-1"></i> Pending</span>
                                    @elseif($izin->status === 'approved')
                                        <span class="bg-emerald-50 text-emerald-700 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wide border border-emerald-200"><i class="fa-solid fa-circle-check mr-1"></i> Disetujui</span>
                                    @elseif($izin->status === 'rejected')
                                        <span class="bg-rose-50 text-rose-700 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wide border border-rose-200"><i class="fa-solid fa-circle-xmark mr-1"></i> Ditolak</span>
                                    @elseif($izin->status === 'out')
                                        <span class="bg-purple-50 text-purple-700 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wide border border-purple-200"><i class="fa-solid fa-person-walking-arrow-right mr-1"></i> Di Luar</span>
                                    @elseif($izin->status === 'returned')
                                        <span class="bg-blue-50 text-blue-700 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wide border border-blue-200"><i class="fa-solid fa-house-chimney-user mr-1"></i> Kembali</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center pr-6">
                                    @if(in_array(Auth::user()->role, ['admin', 'ustadz']) && $izin->status === 'pending')
                                        <div class="flex justify-center gap-2">
                                            <form action="{{ route('perizinan.approve', $izin->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm cursor-pointer transition">Setujui</button>
                                            </form>
                                            <form action="{{ route('perizinan.approve', $izin->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold px-3 py-1.5 rounded-xl shadow-sm cursor-pointer transition">Tolak</button>
                                            </form>
                                        </div>
                                    @endif

                                    @if(in_array(Auth::user()->role, ['kamtib', 'admin']))
                                        @if($izin->status === 'approved')
                                            <form action="{{ route('perizinan.checkOut', $izin->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold px-4 py-1.5 rounded-xl shadow-md shadow-purple-500/10 cursor-pointer transition"><i class="fa-solid fa-door-open mr-1"></i> Catat Keluar (Out)</button>
                                            </form>
                                        @elseif($izin->status === 'out')
                                            <form action="{{ route('perizinan.checkIn', $izin->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-1.5 rounded-xl shadow-md shadow-blue-500/10 cursor-pointer transition"><i class="fa-solid fa-right-to-bracket mr-1"></i> Catat Kembali (In)</button>
                                            </form>
                                        @endif
                                    @endif

                                    @if($izin->status === 'approved' && Auth::user()->role === 'wali')
                                        <div class="inline-block bg-slate-900 text-emerald-400 text-xs font-bold px-3 py-1 rounded-lg font-mono tracking-wider border border-slate-800 shadow">
                                            PASS: {{ $izin->token_gatepass }}
                                        </div>
                                    @endif

                                    @if($izin->status === 'returned' || $izin->status === 'rejected')
                                        <span class="text-xs text-slate-400 font-medium"><i class="fa-solid fa-lock text-[10px] mr-1"></i> Record Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-400">
                                    <i class="fa-regular fa-folder-open text-4xl block mb-2 text-slate-300"></i>
                                    Belum ada data pengajuan perizinan terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>