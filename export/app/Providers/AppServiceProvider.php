<?php

namespace App\Providers;

use Statamic\Statamic;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Studio1902\PeakSeo\Handlers\ErrorPage;

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
        ErrorPage::handle404AsEntry();

        Password::defaults(function () {
            if(config('app.env') === 'local') {
                return Password::min(4);
            } else {
                return Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised();
            }
        });
    }
}
