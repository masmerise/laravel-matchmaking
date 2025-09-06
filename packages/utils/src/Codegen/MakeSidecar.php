<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Codegen;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'matchmaking:make:sidecar', aliases: ['make:matchmaking:sidecar'])]
final class MakeSidecar extends GeneratorCommand
{
    use InteractsWithStubs;

    protected $aliases = ['make:matchmaking:sidecar'];

    protected $description = 'Create a new sidecar service provider.';

    protected $signature = 'matchmaking:make:sidecar';

    protected $type = 'SidecarServiceProvider';

    public function handle(): int
    {
        $result = parent::handle();

        if ($result === false) {
            return self::FAILURE;
        }

        $this->components->info('Do not forget to register the provider in each of your interfaces that need it!');

        return self::SUCCESS;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        if ($this->files->isDirectory($path = "{$rootNamespace}/Providers")) {
            return $path;
        }

        return $rootNamespace;
    }

    protected function getNameInput(): string
    {
        return 'SidecarServiceProvider';
    }

    protected function getStub(): string
    {
        return $this->stubPath('sidecar.stub');
    }
}
