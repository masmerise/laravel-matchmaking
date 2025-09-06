<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Packages;

use Composer\InstalledVersions;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Support\Collection;

final class DevPackageManifest extends PackageManifest
{
    public static function create(Filesystem $files, string $basePath, string $manifestPath): self
    {
        return new self($files, $basePath, $manifestPath);
    }

    public function build(): self
    {
        parent::build();

        return $this;
    }

    public function collect(): Collection
    {
        return Collection::make($this->getManifest());
    }

    protected function packagesToIgnore(): array
    {
        if (! $this->files->exists($path = "{$this->vendorPath}/composer/installed.json")) {
            return parent::packagesToIgnore();
        }

        $installed = json_decode($this->files->get($path), true);
        $versions = InstalledVersions::getAllRawData()[0]['versions'];
        $isDevRequirement = static fn (string $name) => $versions[$name]['dev_requirement'] ?? false;

        return Collection::make($installed['packages'] ?? $installed)
            ->filter(static fn (array $package) => $package['extra']['laravel'] ?? false)
            ->map(static fn (array $package) => $package['name'])
            ->reject($isDevRequirement)
            ->values()
            ->concat(parent::packagesToIgnore())
            ->all();
    }
}
