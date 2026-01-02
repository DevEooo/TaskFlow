<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskFlow - SI Monitoring OB</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        
        {{-- BAGIAN ATAS (NAVIGASI UNTUK USER YANG SUDAH LOGIN) --}}
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                {{-- Gunakan rute base panel Filament: /admin --}}
                @if(auth()->user()->role === 'admin')
                    <a href="/admin" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Admin Dashboard</a>
                @endif
            @endauth
        </div>
        
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex flex-col items-center justify-center mb-12">
                {{-- Logo dan Teks --}}
                {{-- (SVG dan Teks Welcome Anda di sini) --}}
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Selamat datang di TaskFlow</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 text-center max-w-2xl">
                    Kelola tugas, track absensi, dan kolaborasi dengan timmu secara efisien.
                </p>
                
                {{-- BAGIAN UTAMA (LOGIN/REGISTER UNTUK SEMUA USER) --}}
                <div class="flex flex-col sm:flex-row gap-4 mb-4">
                    {{-- 1. Tombol Login OB/User --}}
                    <a href="/user/login" class="inline-flex items-center justify-center px-10 py-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login OB / Staff
                    </a>

                    {{-- 2. Tombol Register (Jika Diizinkan) --}}
                    {{-- Catatan: Biasanya Register untuk OB/Staff dikontrol Admin, tapi kita sediakan link ini --}}
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-semibold rounded-lg shadow-lg border-2 border-gray-300 dark:border-gray-600 transition-all duration-200 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Register
                    </a>
                </div>

                {{-- 3. Link Khusus Admin Login --}}
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                    Akses **Supervisor/Admin**? <a href="/admin/login" class="text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 font-semibold underline">Login di sini</a>
                </p>
            </div>
            
            {{-- Konten Footer (Docs, Laracasts, etc.) --}}
            {{-- (Sisa kode Anda di sini) --}}
            
        </div>
    </div>
</body>
</html>