<?php

namespace Ismailua\UblTrInvoice\Facades;

use Illuminate\Support\Facades\Facade;

class UBLInvoice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ubl-invoice';
    }
}
