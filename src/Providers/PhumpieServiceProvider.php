<?php

namespace Phumsoft\Phumpie\Providers;

use Illuminate\Support\ServiceProvider;

class PhumpieServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootTranslation();
    }

    /**
     * Boot Translation.
     *
     * @return void
     */
    private function bootTranslation()
    {
        $this->publishes([
            __DIR__ . '/../../lang' => lang_path(),
        ], 'phumpie');

        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'phumpie');
    }
}
