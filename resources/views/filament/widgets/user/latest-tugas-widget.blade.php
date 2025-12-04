<x-filament-widgets::widget>
    <!-- Penggunaan card besar tunggal untuk menonjolkan fokus utama (UX: "Apa yang harus saya lakukan sekarang?") -->
    <x-filament::card class="p-8 shadow-xl dark:shadow-2xl border-t-4 border-primary-600 dark:border-primary-400 rounded-xl">
        
        @if($task)
            <!-- Konten Jika Ada Tugas Aktif -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-4 md:space-y-0 md:space-x-8">
                
                <!-- Kiri: Judul dan Detail Tugas -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                        Fokus Utama Anda: Tugas Terbaru
                    </p>
                    
                    <!-- Judul Tugas (Paling menonjol) -->
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white truncate" title="{{ $task->title }}">
                        <x-filament::icon icon="heroicon-m-clipboard-document-check" class="h-8 w-8 inline-block mr-2 text-primary-600 dark:text-primary-400" />
                        {{ $task->title }}
                    </h2>

                    <!-- Detail Tambahan (Tanggal & Status) -->
                    <div class="mt-4 flex flex-wrap gap-4 text-sm font-medium">
                        
                        <!-- Status Badge -->
                        <div class="flex items-center space-x-2">
                            <x-filament::icon icon="heroicon-m-tag" class="h-5 w-5 text-gray-400" />
                            <span class="text-gray-700 dark:text-gray-300">Status:</span>
                            <x-filament::badge color="{{ $statusColor }}">
                                {{ $statusLabel }}
                            </x-filament::badge>
                        </div>

                        <!-- Tanggal Dibuat -->
                        <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                            <x-filament::icon icon="heroicon-m-calendar" class="h-5 w-5 text-gray-400" />
                            <span>Dibuat:</span>
                            <span class="font-bold">{{ $task->created_at->translatedFormat('d F Y') }}</span>
                            <span class="text-xs italic">({{ $task->created_at->diffForHumans() }})</span>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Tombol Call to Action (CTA) -->
                <div class="flex-shrink-0 w-full md:w-auto">
                    <x-filament::link
                        :href="\App\Filament\Resources\User\TugasKus\TugasKuResource::getUrl('edit', ['record' => $task->id], panel: 'user')"
                        tag="a"
                        color="primary"
                        size="xl"
                        class="flex items-center justify-center space-x-2 w-full px-6 py-3 text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition duration-150 shadow-lg hover:shadow-xl font-bold whitespace-nowrap"
                    >
                        <x-filament::icon icon="heroicon-m-arrow-path" class="h-6 w-6" />
                        <span>Lanjutkan Tugas Ini</span>
                    </x-filament::link>
                </div>
            </div>
            
        @else
            <!-- Konten Jika Tidak Ada Tugas Aktif -->
            <div class="flex flex-col items-center justify-center text-center py-6">
                <x-filament::icon
                    icon="heroicon-o-face-smile"
                    class="h-12 w-12 text-success-500 dark:text-success-400 mb-4"
                />
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Semua Tugas Selesai!
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Anda tidak memiliki tugas yang *Pending* atau *On Progress* saat ini. Kerja bagus!
                </p>
                <!-- CTA untuk membuat tugas baru -->
                <x-filament::link
                    href="{{ \App\Filament\Resources\User\TugasKus\TugasKuResource::getUrl('create', panel: 'user') }}"
                    tag="a"
                    color="success"
                    size="md"
                    class="flex items-center justify-center space-x-2 px-5 py-2 text-white bg-success-600 rounded-lg hover:bg-success-700 transition font-bold shadow"
                >
                    <x-filament::icon icon="heroicon-m-plus-circle" class="h-5 w-5" />
                    <span>Buat Tugas Baru Sekarang</span>
                </x-filament::link>
            </div>
        @endif

    </x-filament::card>
</x-filament-widgets::widget>