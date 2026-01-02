    <x-filament-panels::modal
    id="custom-database-notifications"
    :close-button="false"
    :slide-over="false"
    class="fi-modal"
    x-data="{
        show: false,
        init() {
            $wire.on('open-modal', (event) => {
                if (event.id === 'custom-database-notifications') {
                    this.show = true;
                }
            });
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    style="display: none;"
>
    <div class="fi-modal-window">
        <div class="fi-modal-header">
            <div class="fi-modal-heading">
                <h2 class="fi-modal-heading-title">Notifikasi</h2>
            </div>
            <div class="fi-modal-actions">
                <x-filament::icon-button
                    color="gray"
                    :icon="\Filament\Support\Icons\Heroicon::OutlinedXMark"
                    icon-size="lg"
                    :label="__('filament-panels::layout.actions.close_modal.label')"
                    x-on:click="show = false"
                    class="fi-modal-close-btn"
                />
            </div>
        </div>
        <div class="fi-modal-content">
            <div class="space-y-4">
                @if ($notifications->isEmpty())
                    <div class="text-center text-gray-500">
                        Tidak ada notifikasi.
                    </div>
                @else
                    @foreach ($notifications as $notification)
                        <div
                            class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors"
                            wire:key="notification-{{ $notification->id }}"
                        >
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $notification->data['title'] ?? 'Notifikasi' }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $notification->data['body'] ?? '' }}</p>
                                    <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <x-filament::button
                                        color="red"
                                        size="sm"
                                        wire:click="deleteNotification('{{ $notification->id }}')"
                                        class="fi-btn fi-size-sm fi-color-red"
                                    >
                                        Hapus
                                    </x-filament::button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="fi-modal-footer">
            <div class="flex justify-between items-center">
                <x-filament::button
                    color="red"
                    wire:click="deleteAllNotifications"
                    class="fi-btn fi-color-red"
                >
                    Hapus Semua
                </x-filament::button>
                <x-filament::button
                    color="gray"
                    x-on:click="show = false"
                    class="fi-btn fi-color-gray"
                >
                    Tutup
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament-panels::modal>
