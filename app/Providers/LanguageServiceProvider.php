<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $languages = collect(LaravelLocalization::getSupportedLocales() );
        $current = LaravelLocalization::getCurrentLocale();
        $locals = (clone $languages)->forget($current)->keys()->toArray();
        view()->share('locals' , $locals);

        $languages = $languages->keys()->toArray();
        view()->share('languages' , $languages);

        view()->share('current_lang' , app()->getLocale());

    }
}
