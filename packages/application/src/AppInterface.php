<?php declare(strict_types=1);

namespace Masmerise\Matchmaking;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;

interface AppInterface
{
    public function connect(Repository $config, Application $app): void;
}
