<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if(App::environment('production')) {
            $url->forceScheme('https');
        }

        $this->loadViewsFrom(resource_path('views'), 'master');
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(app_path('Helpers/functions') . DIRECTORY_SEPARATOR . '*.php') as $filename) {
            require_once $filename;
        }
    }
}
