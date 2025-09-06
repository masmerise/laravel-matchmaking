<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Codegen;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'matchmaking:make:console', aliases: ['make:matchmaking:console'])]
final class MakeConsoleInterface extends GeneratorCommand
{
    use InteractsWithStubs;

    protected $aliases = ['make:matchmaking:console'];

    protected $description = 'Create a new console interface.';

    protected $signature = 'matchmaking:make:console {name}';

    protected $type = 'Interface';

    public function handle(): int
    {
        $result = parent::handle();

        if ($result === false) {
            return self::FAILURE;
        }

        $this->components->info('Do not forget to register in the console.php bootstrap file!');

        return self::SUCCESS;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\Console";
    }

    protected function getStub(): string
    {
        return $this->stubPath('interface.console.stub');
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => ['What should be the name of the console interface?', 'E.g. ConsoleInterface'],
        ];
    }
}
