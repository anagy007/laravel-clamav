<?php
declare(strict_types=1);

namespace Crys\Clamav;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('clamav.php'),
        ]);

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'clamav');

        $message = $this->app->translator->trans('clamav::validation.clamav');
        $this->app->validator->extend('clamav', Validator::class . '@validate', $message);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'clamav'
        );
    }
}
