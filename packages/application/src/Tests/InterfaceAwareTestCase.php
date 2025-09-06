<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase;
use Masmerise\Matchmaking\Http\HttpInterface;

abstract class InterfaceAwareTestCase extends TestCase
{
    abstract protected function interface(): HttpInterface;

    public function createApplication(): Application
    {
        $app = require Application::inferBasePath() . '/bootstrap/app.php';
        $app->instance('matchmaking.testing.interface', $this->interface());

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
