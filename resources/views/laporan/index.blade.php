<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Laporan Perizinan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-emerald-600 text-white p-4 shadow-md">
        <div class="container mx-auto">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold hover:underline">← Kembali ke Dashboard</a>
        </div>
    </nav>

    <main class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Rekap & Laporan Perizinan Santri</h2>

        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="w-full text-sm border border-gray-300 p-2 rounded">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="w-full text-sm border border-gray-300 p-2 rounded">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status Izin</label>
                    <select name="status" class="w-full text-sm border border-gray-300 p-2 rounded">
                        <option value="">-- Semua Status --</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="out" {{ request('status') === 'out' ? 'selected' : '' }}>Di Luar</option>
                        <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Kembali</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-2 rounded shadow transition">
                        Filter Data
                    </button>
                    <a href="{{ route('laporan.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium py-2 px-3 rounded transition text-center shadow">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-800 text-white uppercase text-xs border-b">
                        <th class="p-4">Nama Santri</th>
                        <th class="p-4">Wali Murid (Pengaju)</th>
                        <th class="p-4">Alasan</th>
                        <th class="p-4">Waktu Keluar</th>
                        <th class="p-4">Waktu Kembali</th>
                        <th class="p-4">Status Akhir</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-xs divide-y divide-gray-200">
                    @forelse($laporans as $lap)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 font-bold text-gray-800">{{ $lap->santri->nama_santri }}</td>
                            <td class="p-4">{{ $lap->user->name }}</td>
                            <td class="p-4">{{ $lap->alasan }}</td>
                            <td class="p-4">
                                {{ \Carbon\Carbon::parse($lap->tgl_jemput)->format('d/m/Y') }}<br>
                                <span class="text-gray-400 text-[10px]">{{ $lap->jam_jemput }}</span>
                            </td>
                            <td class="p-4">
                                {{ \Carbon\Carbon::parse($lap->tgl_kembali)->format('d/m/Y') }}<br>
                                <span class="text-gray-400 text-[10px]">{{ $lap->jam_kembali }}</span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 font-semibold rounded text-[10px] uppercase
                                    {{ $lap->status === 'returned' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $lap->status === 'out' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $lap->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $lap->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $lap->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ $lap->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">Tidak ada data rekap perizinan yang cocok dengan filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>