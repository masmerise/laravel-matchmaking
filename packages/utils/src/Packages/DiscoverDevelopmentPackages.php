<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Packages;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'matchmaking:package:discover-dev', aliases: ['package:discover-dev'])]
final class DiscoverDevelopmentPackages extends Command
{
    protected $aliases = ['package:discover-dev'];

    protected $description = 'Rebuild the cached package manifest for development.';

    protected $signature = 'matchmaking:package:discover-dev';

    public function handle(Filesystem $files): int
    {
        $this->components->info('Discovering development packages.');

        DevPackageManifest::create($files, $this->laravel->basePath(), $this->laravel->getCachedPackagesPath())
            ->build()
            ->collect()
            ->keys()
            ->each(fn (string $description) => $this->components->task($description))
            ->whenNotEmpty(fn () => $this->newLine());

        return self::SUCCESS;
    }
}
