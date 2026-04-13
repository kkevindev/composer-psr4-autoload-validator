<?php

declare(strict_types=1);

namespace Kkevindev\ComposerPSR4AutoloadValidator;

final readonly class Validator
{
    public function validate(): Result
    {
        $command = '$(command -v composer) dump-autoload --optimize --strict-psr --no-interaction 2>&1';
        $outputLines = [];
        $exitCode = 0;

        exec($command, $outputLines, $exitCode);

        $rawOutput = trim(implode("\n", $outputLines));
        $violations = $this->extractViolations($outputLines);

        return new Result($exitCode, $rawOutput, $violations);
    }

    /**
     * @param list<string> $outputLines
     *
     * @return list<string>
     */
    private function extractViolations(array $outputLines): array
    {
        $violations = [];

        foreach ($outputLines as $line) {
            $line = trim($line);

            if (!str_contains($line, 'does not comply with psr-4 autoloading standard')) {
                continue;
            }

            $line = explode(' does not comply with psr-4 autoloading standard', $line)[0];

            $violations[] = $line;
        }

        return $violations;
    }
}
