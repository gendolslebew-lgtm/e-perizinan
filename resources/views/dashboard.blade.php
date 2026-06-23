<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard E-Perizinan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen font-sans text-slate-800 antialiased">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200/80 shadow-sm">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-tr from-emerald-500 to-teal-600 p-2.5 rounded-xl shadow-md shadow-emerald-500/20">
                    <i class="fa-solid fa-shield-halved text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-lg font-extrabold tracking-tight bg-gradient-to-r from-emerald-600 to-teal-700 bg-clip-text text-transparent">E-PERIZINAN</span>
                    <span class="block text-[10px] text-slate-400 font-medium tracking-wider uppercase">Pondok Pesantren</span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <span class="block text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                    <span class="text-xs bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wide text-[9px] border border-emerald-200">{{ Auth::user()->role }}</span>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 p-2.5 rounded-xl transition duration-300 group cursor-pointer" title="Keluar Sistem">
                        <i class="fa-solid fa-right-from-bracket group-hover:translate-x-0.5 transition"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8 px-6 pb-12">
        <div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 rounded-3xl p-8 md:p-10 shadow-xl shadow-emerald-950/10 mb-8 relative overflow-hidden text-white">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 max-w-xl">
                <span class="text-emerald-400 text-xs font-bold uppercase tracking-widest bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">Selamat Datang</span>
                <h1 class="text-3xl md:text-4xl font-black tracking-tight mt-3">Sistem Pusat Kontrol Kendali Perizinan</h1>
                <p class="text-slate-300 text-sm mt-2 leading-relaxed">Kelola, tinjau, dan pantau keluar masuknya santri secara real-time demi keamanan lingkungan pesantren.</p>
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('perizinan.index') }}" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/20 transition duration-300">
                        <i class="fa-solid fa-folder-open mr-2"></i> Buka Data Perizinan
                    </a>
                    @if(in_array(Auth::user()->role, ['admin', 'ustadz']))
                    <a href="{{ route('laporan.index') }}" class="bg-white/10 hover:bg-white/15 backdrop-blur border border-white/10 px-5 py-2.5 rounded-xl text-sm font-bold transition duration-300">
                        <i class="fa-solid fa-chart-pie mr-2"></i> Rekap Laporan
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Ringkasan Perizinan Saat Ini</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            @if(Auth::user()->role === 'wali')
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-sm font-medium text-slate-400">Total Pengajuan</span>
                            <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats['total_izin'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-blue-50 text-blue-600 p-3 rounded-xl group-hover:scale-110 transition duration-300"><i class="fa-solid fa-paper-plane text-lg"></i></div>
                    </div>
                </div>
            @else
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-sm font-medium text-slate-400">Total Data Santri</span>
                            <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats['total_santri'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-indigo-50 text-indigo-600 p-3 rounded-xl group-hover:scale-110 transition duration-300"><i class="fa-solid fa-graduation-cap text-lg"></i></div>
                    </div>
                </div>
            @endif

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-sm font-medium text-slate-400">Menunggu Persetujuan</span>
                        <h3 class="text-3xl font-black text-amber-600 mt-1">{{ $stats['pending'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-amber-50 text-amber-600 p-3 rounded-xl group-hover:scale-110 transition duration-300"><i class="fa-solid fa-clock-rotate-left text-lg"></i></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-sm font-medium text-slate-400">Santri di Luar Pesantren</span>
                        <h3 class="text-3xl font-black text-purple-600 mt-1">{{ $stats['di_luar'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-purple-50 text-purple-600 p-3 rounded-xl group-hover:scale-110 transition duration-300"><i class="fa-solid fa-door-open text-lg"></i></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition group duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-sm font-medium text-slate-400">Izin Selesai (Kembali)</span>
                        <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ $stats['approved'] ?? $stats['selesai'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-emerald-50 text-emerald-600 p-3 rounded-xl group-hover:scale-110 transition duration-300"><i class="fa-solid fa-circle-check text-lg"></i></div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>