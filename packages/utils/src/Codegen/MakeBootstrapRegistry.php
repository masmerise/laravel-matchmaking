<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Codegen;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'matchmaking:make:bootstrap', aliases: ['make:matchmaking:bootstrap'])]
final class MakeBootstrapRegistry extends Command
{
    use InteractsWithStubs;

    protected $aliases = ['make:matchmaking:bootstrap'];

    protected $description = 'Create the matchmaking bootstrap registry.';

    protected $signature = 'matchmaking:make:bootstrap';

    public function handle(Filesystem $files): int
    {
        if ($files->isDirectory($destination = $this->laravel->bootstrapPath('matchmaking'))) {
            $this->components->warn('The bootstrap registry already exists.');

            return self::FAILURE;
        }

        $this->components->info('Creating the registry in bootstrap/matchmaking...');
        $files->makeDirectory($destination);
        $files->copy($this->stubPath('bootstrap.console.stub'), "{$destination}/console.php");
        $files->copy($this->stubPath('bootstrap.http.stub'), "{$destination}/http.php");

        return self::SUCCESS;
    }

    public function isHidden(): bool
    {
        return true;
    }
}
