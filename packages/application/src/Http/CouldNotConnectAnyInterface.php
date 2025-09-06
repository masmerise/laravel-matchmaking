<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Http;

use RuntimeException;

final class CouldNotConnectAnyInterface extends RuntimeException
{
    public static function becauseNoInterfaceMatched(): self
    {
        return new self('No interface matches the current request.');
    }
}
