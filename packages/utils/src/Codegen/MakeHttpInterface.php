<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Codegen;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'matchmaking:make:http', aliases: ['make:matchmaking:http'])]
final class MakeHttpInterface extends GeneratorCommand
{
    use InteractsWithStubs;

    protected $aliases = ['make:matchmaking:http'];

    protected $description = 'Create a new http interface.';

    protected $signature = 'matchmaking:make:http {name}';

    protected $type = 'Interface';

    public function handle(): int
    {
        $result = parent::handle();

        if ($result === false) {
            return self::FAILURE;
        }

        $this->components->info('Do not forget to register in the http.php bootstrap file!');

        return self::SUCCESS;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return "{$rootNamespace}\Http";
    }

    protected function getStub(): string
    {
        return $this->stubPath('interface.http.stub');
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => ['What should be the name of the http interface?', 'E.g. ApiInterface'],
        ];
    }
}
