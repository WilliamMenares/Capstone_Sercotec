<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Empresa;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->share('cantidadEmpresas', Empresa::count());
    }
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
}
