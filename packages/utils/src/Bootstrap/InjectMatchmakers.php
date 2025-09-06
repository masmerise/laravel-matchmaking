<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Bootstrap;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'matchmaking:inject', aliases: ['inject:matchmaking'])]
final class InjectMatchmakers extends Command
{
    protected $aliases = ['inject:matchmaking'];

    protected $description = 'Inject the matchmakers into the application kernels.';

    protected $signature = 'matchmaking:inject';

    public function handle(Filesystem $files): int
    {
        foreach (['Http', 'Console'] as $type) {
            $this->inject($files, $type);
        }

        return self::SUCCESS;
    }

    private function inject(Filesystem $files, string $type): void
    {
        if (! $files->exists($path = $this->laravel->path("{$type}/Kernel.php"))) {
            $this->components->error("{$type} injection failed as the kernel does not exist.");

            return;
        }

        $kernel = $files->get($path);

        if (str_contains($kernel, 'Masmerise\\Matchmaking')) {
            $this->components->warn("{$type} injection skipped as the kernel already contains the matchmaker.");

            return;
        }

        $kernel = str_replace("Illuminate\\Foundation\\{$type}\\Kernel", "Masmerise\\Matchmaking\\{$type}\\Kernel", $kernel);

        $files->put($path, $kernel);

        $this->components->success("{$type} kernel injection successful.");
    }

    public function isHidden(): bool
    {
        return true;
    }
}
