<?php

namespace DavidMaximous\Fawrypay;

use Illuminate\Support\ServiceProvider;
use DavidMaximous\FawryPay\Classes\FawryPayment;
use DavidMaximous\Fawrypay\Classes\FawryVerify;

class FawryPayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configure();

        $langPath = __DIR__ . '/../resources/lang';

        $this->registerPublishing($langPath);

        $this->loadTranslationsFrom($langPath, 'fawrypay');

        $this->publishes([
            __DIR__ . '/../config/fawrypay.php' => config_path('fawrypay.php'),
            $langPath => resource_path('lang/vendor/fawrypay'),
        ], 'fawrypay-all');
    }

    public function register()
    {
        $this->app->bind(FawryPayment::class, function () {
            return new FawryPayment();
        });
        $this->app->bind(FawryVerify::class, function () {
            return new FawryVerify();
        });
    }

    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/fawrypay.php',
            'fawrypay'
        );
    }

    protected function registerPublishing($langPath)
    {
        $this->publishes([
            __DIR__ . '/../config/fawrypay.php' => config_path('fawrypay.php'),
        ], 'fawrypay-config');

        $this->publishes([
            $langPath => resource_path('lang/vendor/fawrypay'),
        ], 'fawrypay-lang');
    }
}
