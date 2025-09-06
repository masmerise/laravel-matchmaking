<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Codegen;

trait InteractsWithStubs
{
    private function stubPath(string $path): string
    {
        return __DIR__ . "/../../stubs/{$path}";
    }
}
