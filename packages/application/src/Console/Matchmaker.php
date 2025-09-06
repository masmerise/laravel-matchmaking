<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Console;

use Illuminate\Foundation\Application;
use Masmerise\Matchmaking\AppInterface;

final readonly class Matchmaker
{
    public function bootstrap(Application $app): void
    {
        /** @var AppInterface $interface */
        $interface = $app->runningUnitTests() && $app->bound('matchmaking.testing.interface')
            ? $app['matchmaking.testing.interface']
            : $app[require $app->bootstrapPath('matchmaking/console.php')];

        $interface->connect($app['config'], $app);
    }
}
