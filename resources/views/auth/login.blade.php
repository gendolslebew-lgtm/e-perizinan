<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E-Perizinan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center h-screen font-sans">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-emerald-600">E-Perizinan Pesantren</h2>
            <p class="text-sm text-gray-500 mt-1">Silakan masuk menggunakan akun seeder kamu</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh: admin@pesantren.com" class="w-full border p-2 rounded focus:outline-emerald-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full border p-2 rounded focus:outline-emerald-500" required>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded transition shadow">
                Masuk Sistem
            </button>
        </form>

        <!-- Petunjuk Akun untuk Dosen -->
        <div class="mt-6 p-3 bg-amber-50 border border-amber-200 rounded text-[11px] text-amber-800">
            <span class="font-bold block mb-1">💡 Akun Uji Coba (Password: password):</span>
            • Wali: wali@pesantren.com <br>
            • Admin: admin@pesantren.com <br>
            • Ustadz: ustadz@pesantren.com <br>
            • Kamtib: kamtib@pesantren.com <br>
        </div>
    </div>

</body>
</html>