<?php declare(strict_types=1);

namespace Masmerise\Matchmaking\Utility\Codegen;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'matchmaking:make:test-case', aliases: ['make:matchmaking:test-case'])]
final class MakeTestCase extends GeneratorCommand
{
    use InteractsWithStubs;

    protected $description = 'Create a new interface aware test case.';

    protected $signature = 'matchmaking:make:test-case {name} {interface}';

    protected $type = 'Test';

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this
            ->replaceNamespace($stub, $name)
            ->replaceInterface($stub, $this->argument('interface'))
            ->replaceClass($stub, $name);
    }

    protected function getNameInput(): string
    {
        $name = parent::getNameInput();

        if (str_ends_with($name, 'TestCase')) {
            $name = Str::replaceLast('TestCase', '', $name);
        }

        $name .= 'TestCase';

        return $name;
    }

    protected function getStub(): string
    {
        return $this->stubPath('test-case.stub');
    }

    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path('tests') . str_replace('\\', '/', $name) . '.php';
    }

    protected function replaceInterface(string &$stub, string $namespace): self
    {
        $stub = str_replace('{{ interfaceNamespace }}', $namespace, $stub);

        $interface = class_basename($namespace);
        $stub = str_replace('{{ interface }}', $interface, $stub);

        return $this;
    }

    protected function rootNamespace(): string
    {
        return 'Tests';
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => [
                'What should the test case be named?',
                'E.g. WebhooksTestCase',
            ],
            'interface' => [
                'What is the fully qualified class namespace of the http interface you want to create a test case for?',
                'E.g. App\Http\Webhooks\WebhooksInterface',
            ],
        ];
    }
}
