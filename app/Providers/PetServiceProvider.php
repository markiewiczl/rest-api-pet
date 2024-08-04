<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\PetServiceInterface;
use App\Services\PetService;
use Illuminate\Support\ServiceProvider;

class PetServiceProvider extends ServiceProvider
{
    public $bindings = [
        PetServiceInterface::class => PetService::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(PetService::class)
            ->needs('$name')
            ->give('Base Pet Service');
    }
}
