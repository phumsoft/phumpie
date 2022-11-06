<?php

namespace Phumpie\Providers;

use Illuminate\Support\ServiceProvider;

class PhumpieServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishResources();
    }

    /**
     * Publish resources.
     *
     * @return void
     */
    private function publishResources()
    {
    }
}
