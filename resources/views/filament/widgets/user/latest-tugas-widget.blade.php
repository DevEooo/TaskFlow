<x-filament-widgets::widget>
    <!-- Card adalah root tag yang disarankan untuk Widget -->
    <x-filament::card class="relative overflow-hidden p-6">
        @if ($task)
            <div class="flex items-center space-x-4">
                <x-filament::icon
                    icon="heroicon-o-clipboard-document-check"
                    class="h-8 w-8 text-primary-500"
                />
                
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-0.5">
                        Tugas Aktif Terbaru
                    </h3>
                    <p class="text-xl font-extrabold text-primary-600 dark:text-primary-400">
                        {{ $task->title }}
                    </p>
                </div>
            </div>

            <div class="mt-4 pt-3 space-y-2">
                <!-- Waktu Diberikan -->
                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-calendar" class="h-4 w-4 text-gray-400" />
                    <span>Ditugaskan: {{ $task->created_at->translatedFormat('l, d F Y') }}</span>
                </p>

                <!-- Status -->
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <x-filament::icon icon="heroicon-o-clock" class="h-4 w-4 text-gray-500" />
                        <span>Status Saat Ini</span>
                    </p>
                    
                    <x-filament::badge :color="$statusColor" class="uppercase">
                        {{ $statusLabel }}
                    </x-filament::badge>
                </div>
                
                <!-- Deskripsi -->
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 italic border-l-2 border-gray-200 pl-3">
                    "{{ Str::limit($task->task_description, 100) }}"
                </p>
            </div>
            
            <!-- Link Aksi -->
            <div class="mt-4 text-right">
                <x-filament::link
                    :href="\App\Filament\Resources\User\TugasKus\TugasKuResource::getUrl('edit', ['record' => $task->id], panel: 'user')"
                    tag="a"
                    color="primary"
                    size="sm"
                >
                    Lihat Detail Tugas
                </x-filament::link>
            </div>
            
        @else
            <!-- Jika tidak ada tugas aktif -->
            <div class="text-center py-6">
                 <x-filament::icon
                    icon="heroicon-o-check-circle"
                    class="h-10 w-10 mx-auto text-success-500"
                />
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mt-3">Semua Tugas Selesai!</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Anda tidak memiliki tugas aktif yang tertunda saat ini.
                </p>
            </div>
        @endif
    </x-filament::card>
</x-filament-widgets::widget>