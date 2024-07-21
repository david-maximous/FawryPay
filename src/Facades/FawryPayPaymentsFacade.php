<?php

namespace DavidMaximous\Fawrypay\Facades;

use Illuminate\Support\Facades\Facade;

class FawryPayPaymentsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'fawrypay';
    }
}
