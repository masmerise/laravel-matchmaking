<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'matchmaking:install', aliases: ['install:matchmaking'])]
final class Install extends Command
{
    protected $aliases = ['install:matchmaking'];

    protected $description = 'Install Matchmaking.';

    protected $signature = 'matchmaking:install';

    public function handle(): int
    {
        $this->call('matchmaking:make:bootstrap');
        $this->call('matchmaking:make:console');

        do {
            $this->call('matchmaking:make:http');
        } while ($this->components->confirm('Would you like to create another http interface?'));

        if ($this->components->confirm('Would you like to create a fallback interface?')) {
            $this->call('matchmaking:make:fallback');
        }

        $this->call('matchmaking:make:sidecar');
        $this->call('matchmaking:restrict-package-discovery');
        $this->call('matchmaking:inject');

        $this->components->success('Matchmaking installed!');

        return self::SUCCESS;
    }
}
