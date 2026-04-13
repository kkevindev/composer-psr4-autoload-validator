<?php

declare(strict_types=1);

namespace Kkevindev\ComposerPSR4AutoloadValidator\Command;

use Kkevindev\ComposerPSR4AutoloadValidator\Validator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(self::COMMAND_NAME, description: 'Validate PSR-4 autoloading in the current directory. Requires composer to be installed and composer.json to be found at the current directory.')]
final class ValidateCommand extends Command
{
    public const string COMMAND_NAME = 'kkevindev:composer-psr4-autoload-validator:validate';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $result = (new Validator())->validate();

        if ($result->hasViolations()) {
            $count = count($result->violations);
            $io->error(sprintf('Found %d PSR-4 autoload error%s.', $count, 1 === $count ? '' : 's'));
            $io->listing($result->violations);

            return Command::FAILURE;
        }

        if (0 !== $result->exitCode) {
            $io->error('' !== $result->rawOutput ? $result->rawOutput : 'Composer failed without output.');

            return $result->exitCode;
        }

        $io->success('No PSR-4 autoload errors found.');

        return Command::SUCCESS;
    }
}
