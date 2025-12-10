<x-filament-widgets::widget>
    <x-filament::card class="h-full relative overflow-hidden shadow-md border border-gray-100 dark:border-gray-700">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary-50 dark:bg-primary-900/50 rounded-lg">
                    <x-filament::icon 
                        icon="heroicon-o-clock" 
                        class="h-6 w-6 text-primary-600 dark:text-primary-400" 
                    />
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Jadwal Hari Ini
                    </h2>
                    <p class="text-xs text-gray-400 dark:text-gray-500">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>
            
            <!-- Status Badge -->
            @if($schedule)
                <x-filament::badge :color="$statusColor">
                    {{ $statusLabel }}
                </x-filament::badge>
            @endif
        </div>

        @if ($schedule && $schedule->shift)
            <!-- Konten Jika Ada Jadwal -->
            <div class="space-y-4">
                <div class="text-center py-2">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                        {{ $schedule->shift->name }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Shift Kerja
                    </p>
                </div>

                <!-- Time Grid -->
                <div class="grid grid-cols-2 gap-4 border-t border-gray-100 dark:border-gray-700 pt-4">
                    <div class="text-center border-r border-gray-100 dark:border-gray-700">
                        <span class="text-xs text-gray-400 uppercase font-bold">Mulai</span>
                        <p class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($schedule->shift->start_time)->format('H:i') }}
                        </p>
                    </div>
                    <div class="text-center">
                        <span class="text-xs text-gray-400 uppercase font-bold">Selesai</span>
                        <p class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                            {{ \Carbon\Carbon::parse($schedule->shift->end_time)->format('H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Konten Jika Libur / Tidak Ada Jadwal -->
            <div class="flex flex-col items-center justify-center py-6 text-center">
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center mb-3">
                    <x-filament::icon 
                        icon="heroicon-o-face-smile" 
                        class="h-8 w-8 text-gray-400" 
                    />
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                    Hari Ini Libur
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-[200px]">
                    Tidak ada jadwal shift yang ditentukan untuk Anda hari ini.
                </p>
            </div>
        @endif

    </x-filament::card>
</x-filament-widgets::widget>