<?php

namespace App\Providers;

use App\Models\Allocation;
use App\Models\Employee;
use App\Observers\AllocationObserver;
use App\Observers\EmployeeObserver;
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
        Employee::observe(EmployeeObserver::class);
        Allocation::observe(AllocationObserver::class);
    }
}
