<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Http;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Masmerise\Matchmaking\AppInterface;

interface HttpInterface extends AppInterface
{
    public function matches(Repository $config, Request $request): bool;
}
