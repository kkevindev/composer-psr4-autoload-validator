<?php

declare(strict_types=1);

namespace Kkevindev\ComposerPSR4AutoloadValidator\Tests;

use Kkevindev\ComposerPSR4AutoloadValidator\Command\ValidateCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Zenstruck\Console\Test\TestCommand;

#[CoversClass(ValidateCommand::class)]
final class ValidateCommandTest extends TestCase
{
    private ?string $previousWorkingDirectory;

    protected function setUp(): void
    {
        $this->previousWorkingDirectory = getcwd() ?: dirname(__DIR__);

        chdir(dirname(__DIR__));
    }

    protected function tearDown(): void
    {
        chdir($this->previousWorkingDirectory);
    }

    public function testValidateThisProjectAutoloadNamespaces(): void
    {
        TestCommand::for(new ValidateCommand())
            ->execute()
            ->assertSuccessful()
            ->assertOutputContains('No PSR-4 autoload errors found.');
    }

    public function testValidateInvalidTempProjectNamespaces(): void
    {
        $fileLocation = 'tests/InvalidNamespaceClass.php';

        file_put_contents($fileLocation, '<?php namespace Kkevindev\\ComposerPSR4AutoloadValidator\\Tests\\Invalid; class InvalidNamespaceClass {}');

        try {
            TestCommand::for(new ValidateCommand())
                ->execute()
                ->assertFaulty()
                ->assertOutputContains('Found 1 PSR-4 autoload error.')
                ->assertOutputContains('Class Kkevindev\\ComposerPSR4AutoloadValidator\\Tests\\Invalid\\InvalidNamespaceClass located in ./tests/InvalidNamespaceClass.php does not comply with psr-4 autoloading standard');
        } finally {
            unlink($fileLocation);
        }
    }
}
