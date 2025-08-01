<?php

namespace App\Providers;

use App\Models\StudentHotsActivityAnswer; // Import model jawaban siswa
use App\Observers\StudentAnswerObserver;  // Import observer yang sudah dibuat
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        // DAFTARKAN OBSERVER DI SINI
        // Baris ini akan memberitahu Laravel untuk "mengamati" model
        // StudentHotsActivityAnswer dengan StudentAnswerObserver.
        StudentHotsActivityAnswer::observe(StudentAnswerObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}