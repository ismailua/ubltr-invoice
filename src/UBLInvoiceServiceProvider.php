<?php

namespace Ismailua\UblTrInvoice;

use Illuminate\Support\ServiceProvider;
use Ismailua\UblTrInvoice\Services\UBLInvoiceGenerator;

class UBLInvoiceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ubl-invoice.php' => config_path('ubl-invoice.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ubl-invoice.php', 'ubl-invoice');

        $this->app->singleton('ubl-invoice', function () {
            return new UBLInvoiceGenerator();
        });
    }
}
