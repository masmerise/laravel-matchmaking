<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Packages;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'matchmaking:restrict-package-discovery')]
final class RestrictPackageDiscovery extends Command
{
    protected $description = 'Restrict package autodiscovery to development packages only.';

    protected $signature = 'matchmaking:restrict-package-discovery';

    public function handle(Filesystem $files): int
    {
        $schema = $files->get($this->laravel->basePath('composer.json'));

        if (str_contains($schema, 'package:discover-dev')) {
            $this->components->warn('Package autodiscovery is already restricted.');

            return self::SUCCESS;
        }

        if (! str_contains($schema, 'package:discover')) {
            $this->components->info('Package autodiscovery is not in use. There is no need to restrict it.');

            return self::SUCCESS;
        }

        if ($this->components->confirm('Restrict package autodiscovery to dev packages only?')) {
            $schema = str_replace('package:discover', 'package:discover-dev', $schema);

            $files->put($this->laravel->basePath('composer.json'), $schema);

            $this->components->success('Package autodiscovery is now restricted to dev packages only.');
        } else {
            $this->components->warn("It is highly recommended to restrict package autodiscovery to dev packages only as it completely undermines the raison d'être of this package.");
        }

        return self::SUCCESS;
    }

    public function isHidden(): bool
    {
        return true;
    }
}
