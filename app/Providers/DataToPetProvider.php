<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\DataToPetServiceInterface;
use App\Services\DataToPetService;
use Illuminate\Support\ServiceProvider;

class DataToPetProvider extends ServiceProvider
{
    public $bindings = [
        DataToPetServiceInterface::class => DataToPetService::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(DataToPetService::class)
            ->needs('$name')
            ->give('data to test');
    }
}
