<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Http;

use Illuminate\Foundation\Application;

final readonly class Matchmaker
{
    /** @throws CouldNotConnectAnyInterface */
    public function bootstrap(Application $app): void
    {
        $config = $app['config'];
        $request = $app['request'];

        foreach (require $app->bootstrapPath('matchmaking/http.php') as $interface) {
            $interface = $app[$interface];

            if ($interface->matches($config, $request)) {
                $interface->connect($config, $app);

                return;
            }
        }

        throw CouldNotConnectAnyInterface::becauseNoInterfaceMatched();
    }
}
