<x-filament-widgets::widget>
    <div class="grid grid-cols-3 gap-6">
        <!-- Card 1: Latest Task Title -->
        <x-filament::card class="p-6 shadow-md dark:shadow-lg border border-gray-100 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <x-filament::icon
                    icon="heroicon-o-clipboard-document-check"
                    class="h-8 w-8 text-primary-600 dark:text-primary-400"
                />
                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Tugas Terbaru
                    </p>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ $task ? $task->title : 'Tidak ada tugas' }}
                    </h3>
                </div>
            </div>
        </x-filament::card>

        <!-- Card 2: Task Creation Date -->
        <x-filament::card class="p-6 shadow-md dark:shadow-lg border border-gray-100 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <x-filament::icon
                    icon="heroicon-o-calendar"
                    class="h-8 w-8 text-success-600 dark:text-success-400"
                />
                <div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Tanggal Dibuat
                    </p>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ $task ? $task->created_at->translatedFormat('d F Y') : '-' }}
                    </h3>
                </div>
            </div>
        </x-filament::card>

        <!-- Card 3: Status and CTA -->
        <x-filament::card class="p-6 shadow-md dark:shadow-lg border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <x-filament::icon
                        icon="heroicon-o-check-circle"
                        class="h-8 w-8 text-warning-600 dark:text-warning-400"
                    />
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status
                        </p>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $task ? $statusLabel : 'Tidak ada' }}
                        </h3>
                    </div>
                </div>
                @if($task)
                    <x-filament::link
                        :href="\App\Filament\Resources\User\TugasKus\TugasKuResource::getUrl('edit', ['record' => $task->id], panel: 'user')"
                        tag="a"
                        color="primary"
                        size="sm"
                        class="font-semibold hover:underline"
                    >
                        <x-filament::icon icon="heroicon-m-arrow-right" class="h-5 w-5" />
                        Selesaikan Sekarang
                    </x-filament::link>
                @endif
            </div>
        </x-filament::card>
    </div>
</x-filament-widgets::widget>
