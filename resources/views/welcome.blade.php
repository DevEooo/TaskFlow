<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ url('/dashboard-admin') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Admin Dashboard</a>
                @else
                    <a href="{{ url('/dashboard-user') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">User Dashboard</a>
                @endif
            @else
                <a href="{{ url('/dashboard-user/login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                <a href="{{ url('/dashboard-user/register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endauth
        </div>
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex flex-col items-center justify-center mb-12">
                <svg viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto bg-gray-100 dark:bg-gray-900 mb-6">
                    <path d="m16.7 45.3 7.4 18.7 13.8-8V53.7l16.1-15.4 7.5 8 .9-4.2-3.5-17.4v-7.6h-6.4V0l-5.5 8h-9.3L31.3 0v8.2H21.9l-9.5-8v6.4H6.4v7.6L2.9 32.1l.9 4.2 7.3-8 16.1 15.4z" fill="#FF2D20"/>
                    <path d="m20.7 18.5h20.6l-9.4-18.3h-1.8L20.7 18.5zM0 38.7a6.28 6.28 0 0 0 1.1 3.5h13.8c3.7 0 6.6-3 6.6-6.6V31H6.6C3 31 0 34 0 37.7v1zM45.3 38.7v-1c0-3.7-3-6.6-6.6-6.6H31v5.1c0 3.7 3 6.6 6.6 6.6h7.7a6.28 6.28 0 0 0 1.1-3.5z" fill="#FF2D20"/>
                </svg>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Welcome to TaskFlow</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 text-center max-w-2xl">
                    Manage your tasks, track attendance, and collaborate with your team efficiently.
                </p>
                
                @guest
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="{{ url('/dashboard-user/login') }}" class="inline-flex items-center justify-center px-10 py-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg transition-all duration-200 transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Login
                        </a>
                        <a href="{{ url('/dashboard-user/register') }}" class="inline-flex items-center justify-center px-10 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-semibold rounded-lg shadow-lg border-2 border-gray-300 dark:border-gray-600 transition-all duration-200 transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Register
                        </a>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">
                        Admin? <a href="{{ url('/dashboard-admin/login') }}" class="text-amber-600 hover:text-amber-700 dark:text-amber-500 dark:hover:text-amber-400 font-semibold underline">Click here to login</a>
                    </p>
                @endguest
            </div>
            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <a
                        href="https://laravel.com/docs"
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.03] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                    >
                        <div>
                            <div class="h-16 w-16 bg-red-500/10 flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 dark:stroke-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 1 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Documentation</h2>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel, we recommend reading all of the documentation from beginning to end.
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="self-center shrink-0 ml-4 w-6 h-6 text-gray-400 dark:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                    <a
                        href="https://laracasts.com"
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.03] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                    >
                        <div>
                            <div class="h-16 w-16 bg-red-500/10 flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 dark:stroke-gray-400">
                                    <path d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Laracasts</h2>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="self-center shrink-0 ml-4 w-6 h-6 text-gray-400 dark:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                    <a
                        href="https://laravel-news.com"
                        class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.03] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                    >
                        <div>
                            <div class="h-16 w-16 bg-red-500/10 flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 dark:stroke-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h7.5" />
                                </svg>
                            </div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Laravel News</h2>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="self-center shrink-0 ml-4 w-6 h-6 text-gray-400 dark:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                    <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.03] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-500/10 flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 dark:stroke-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.39.458-2.121.458H8.5c-.306 0-.624-.031-.945-.095m0 0a5.598 5.598 0 0 0 .945-.095m-4.35 9.122c.837.88 1.964 1.347 3.175 1.347H7.5c.27 0 .547.01.816.03.75.034 1.523.075 2.29.114.435.02.87.04 1.306.04.783 0 1.57-.02 2.355-.06.314-.013.63-.027.947-.04a5.44 5.44 0 0 0 3.205-1.158c.626-.47.958-1.25.958-2.07 0-.866-.362-1.675-.998-2.29a5.49 5.49 0 0 0-2.29-.985c-.617-.126-1.274-.24-1.94-.342-.683-.103-1.374-.2-2.07-.29m0-9.18c-.254-.962-.585-1.892-.986-2.783-.247-.55-.06-1.21.463-1.511l.657-.38c.551-.318 1.39-.458 2.121-.458H11.5c.306 0 .624.031.945.095m0 0a5.598 5.598 0 0 0-.945.095m4.35-9.122c-.837-.88-1.964-1.347-3.175-1.347H10.5c-.27 0-.547-.01-.816-.03-.75-.034-1.523-.075-2.29-.114-.435-.02-.87-.04-1.306-.04-.783 0-1.57.02-2.355.06-.314.013-.63.027-.947.04a5.44 5.44 0 0 0-3.205 1.158c-.626.47-.958 1.25-.958 2.07 0 .866.362 1.675.998 2.29a5.49 5.49 0 0 0 2.29.985c.617.126 1.274.24 1.94.342.683.103 1.374.2 2.07.29m0 9.18" />
                                </svg>
                            </div>
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Vibrant Ecosystem</h2>
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Laravel's robust library of first-party tools and libraries, such as <a href="https://forge.laravel.com" class="underline hover:text-gray-600 dark:hover:text-gray-300">Forge</a>, <a href="https://vapor.laravel.com" class="underline hover:text-gray-600 dark:hover:text-gray-300">Vapor</a>, <a href="https://nova.laravel.com" class="underline hover:text-gray-600 dark:hover:text-gray-300">Nova</a>, and <a href="https://envoyer.io" class="underline hover:text-gray-600 dark:hover:text-gray-300">Envoyer</a> help you take your projects to the next level. Pair them with powerful open source libraries like <a href="https://laravel.com/docs/billing" class="underline hover:text-gray-600 dark:hover:text-gray-300">Cashier</a>, <a href="https://laravel.com/docs/dusk" class="underline hover:text-gray-600 dark:hover:text-gray-300">Dusk</a>, <a href="https://laravel.com/docs/echo" class="underline hover:text-gray-600 dark:hover:text-gray-300">Echo</a>, <a href="https://laravel.com/docs/horizon" class="underline hover:text-gray-600 dark:hover:text-gray-300">Horizon</a>, <a href="https://laravel.com/docs/sanctum" class="underline hover:text-gray-600 dark:hover:text-gray-300">Sanctum</a>, <a href="https://laravel.com/docs/telescope" class="underline hover:text-gray-600 dark:hover:text-gray-300">Telescope</a>, and more.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left sm:ml-0">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
                <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                    <a href="https://laravel.com" class="hover:text-gray-600 dark:hover:text-gray-300">Laravel.com</a>
                </div>
            </div>
        </div>
    </div>
    <style>
        .bg-dots-darker {
            background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
        }
        @media (prefers-color-scheme: dark) {
            .bg-dots-lighter {
                background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
            }
        }
    </style>
</body>
</html>
