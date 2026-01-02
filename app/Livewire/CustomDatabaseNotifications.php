<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
// use Filament\Notifications\Actions\Action;
// use Filament\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Collection;

class CustomDatabaseNotifications extends Component
{
    public Collection $notifications;
    public int $unreadNotificationsCount;

    public function mount(): void
    {
        $this->loadNotifications();
    }
    
    protected function loadNotifications(): void
    {
        $user = Auth::user();
        $this->notifications = $user->notifications()->latest()->limit(30)->get();
        $this->unreadNotificationsCount = $user->unreadNotifications()->count();
        $this->dispatch('update-database-notifications-count', count: $this->unreadNotificationsCount);
    }
    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications(); 
        \Filament\Notifications\Notification::make()
            ->title('Semua ditandai sebagai telah dibaca.')
            ->success()
            ->send();
    }

    public function markAsRead(string $id): void
    {
        $notification = Auth::user()->unreadNotifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }

        $this->loadNotifications();
    }

    public function deleteNotification(string $id): void
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->delete();
        }

        $this->loadNotifications();
    }

    public function deleteAllNotifications(): void
    {
        Auth::user()->notifications()->delete();
        $this->loadNotifications();
        \Filament\Notifications\Notification::make()
            ->title('Semua notifikasi telah dihapus.')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.custom-database-notifications');
    }
}