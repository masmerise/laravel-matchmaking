<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility;

use Illuminate\Support\AggregateServiceProvider;
use Masmerise\Matchmaking\Utility\Bootstrap\InjectMatchmakers;
use Masmerise\Matchmaking\Utility\Codegen\MakeBootstrapRegistry;
use Masmerise\Matchmaking\Utility\Codegen\MakeConsoleInterface;
use Masmerise\Matchmaking\Utility\Codegen\MakeFallbackInterface;
use Masmerise\Matchmaking\Utility\Codegen\MakeHttpInterface;
use Masmerise\Matchmaking\Utility\Codegen\MakeSidecar;
use Masmerise\Matchmaking\Utility\Codegen\MakeTestCase;
use Masmerise\Matchmaking\Utility\Packages\DiscoverDevelopmentPackages;
use Masmerise\Matchmaking\Utility\Packages\RestrictPackageDiscovery;

final class ServiceProvider extends AggregateServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            DiscoverDevelopmentPackages::class,
            InjectMatchmakers::class,
            Install::class,
            MakeBootstrapRegistry::class,
            MakeConsoleInterface::class,
            MakeFallbackInterface::class,
            MakeHttpInterface::class,
            MakeSidecar::class,
            MakeTestCase::class,
            RestrictPackageDiscovery::class,
        ]);
    }
}
