<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Http;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;

abstract class FallbackInterface implements HttpInterface
{
    public function matches(Repository $config, Request $request): bool
    {
        return true;
    }
}
