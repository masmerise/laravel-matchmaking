<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Http;

use Illuminate\Foundation\Http\Kernel as KernelBase;

abstract class Kernel extends KernelBase
{
    protected $bootstrappers = [
        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        \Masmerise\Matchmaking\Http\Matchmaker::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];
}
