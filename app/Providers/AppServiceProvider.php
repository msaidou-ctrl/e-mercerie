<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\City;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();

        // Preload cities and their quarters into a shared view variable to avoid client-side API calls
        try {
            $citiesWithQuarters = Cache::remember('cities_with_quarters_v1', 3600, function () {
                return City::with(['quarters' => function ($q) { $q->select('id', 'name', 'city_id')->orderBy('name'); }])
                    ->select('id', 'name')
                    ->orderBy('name')
                    ->get()
                    ->mapWithKeys(function ($city) {
                        return [$city->id => $city->quarters->map(function ($q) { return ['id' => $q->id, 'name' => $q->name]; })->toArray()];
                    })->toArray();
            });

            View::share('CITY_QUARTERS_PRELOADED', $citiesWithQuarters);
        } catch (\Exception $e) {
            logger()->warning('Failed to preload CITY_QUARTERS in AppServiceProvider: ' . $e->getMessage());
            View::share('CITY_QUARTERS_PRELOADED', []);
        }
    }
}
