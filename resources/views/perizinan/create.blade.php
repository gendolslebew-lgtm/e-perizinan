<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Izin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-emerald-600 text-white p-4 shadow-md">
        <div class="container mx-auto">
            <a href="{{ route('perizinan.index') }}" class="text-xl font-bold hover:underline">← Kembali ke Daftar Izin</a>
        </div>
    </nav>

    <main class="container mx-auto mt-8 px-4 max-w-2xl">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Formulir Pengajuan Izin Santri</h2>

            <form action="{{ route('perizinan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Santri (Anak)</label>
                    <select name="santri_id" class="w-full border border-gray-300 p-2 rounded focus:outline-emerald-500" required>
                        <option value="">-- Pilih Anak --</option>
                        @foreach($santris as $santri)
                            <option value="{{ $santri->id }}">{{ $santri->nama_santri }} (Kelas: {{ $santri->kelas }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jemput</label>
                        <input type="date" name="tgl_jemput" class="w-full border border-gray-300 p-2 rounded focus:outline-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Jemput</label>
                        <input type="time" name="jam_jemput" class="w-full border border-gray-300 p-2 rounded focus:outline-emerald-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                        <input type="date" name="tgl_kembali" class="w-full border border-gray-300 p-2 rounded focus:outline-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Kembali</label>
                        <input type="time" name="jam_kembali" class="w-full border border-gray-300 p-2 rounded focus:outline-emerald-500" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan / Keperluan Izin</label>
                    <textarea name="alasan" rows="3" placeholder="Contoh: Menghadiri pernikahan kakak kandung / Sakit perlu berobat" class="w-full border border-gray-300 p-2 rounded focus:outline-emerald-500" required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">File Pendukung (Opsional)</label>
                    <input type="file" name="file_pendukung" class="w-full border border-gray-300 p-1 rounded bg-gray-50 text-sm">
                    <p class="text-xs text-gray-400 mt-1">* Format: JPG/PNG, Maksimal 2MB (Surat Dokter/Undangan)</p>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded shadow transition">
                        Kirim Pengajuan Izin
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>