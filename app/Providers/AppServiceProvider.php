<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);


        \BezhanSalleh\LanguageSwitch\LanguageSwitch::configureUsing(function (\BezhanSalleh\LanguageSwitch\LanguageSwitch $switch) {
            $switch
                ->locales(['ar', 'en']); // also accepts a closure
        });

        \App\Models\MaterialReceiptNote::observe(\App\Observers\MaterialReceiptNoteObserver::class);
        \App\Models\GatePass::observe(\App\Observers\GatePassObserver::class);
        \App\Models\MaterialDisposalRequest::observe(\App\Observers\MaterialDisposalRequestObserver::class);
        \App\Models\MaterialReturnRequest::observe(\App\Observers\MaterialReturnRequestObserver::class);
        \App\Models\WorkOrderTransfer::observe(\App\Observers\WorkOrderTransferObserver::class);
    }
}
