<?php

namespace App\Providers;

use App\Models\SettingGroup;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Schema::defaultStringLength(191);
        if (Schema::hasTable('setting_groups'))
        {
            $setting_groups = SettingGroup::all();
            View::share('setting_groups', $setting_groups);
        }
    }
}
