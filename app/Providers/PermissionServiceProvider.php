<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('permissions'))
        {
            Permission::all()->map(function ($permission) {
                Gate::define($permission->name , function ($user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            });
        }
    }
}
