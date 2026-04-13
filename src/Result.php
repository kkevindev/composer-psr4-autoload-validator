<?php

declare(strict_types=1);

namespace Kkevindev\ComposerPSR4AutoloadValidator;

final readonly class Result
{
    /**
     * @param list<string> $violations
     */
    public function __construct(
        public int $exitCode,
        public string $rawOutput,
        public array $violations,
    ) {
    }

    public function hasViolations(): bool
    {
        return !empty($this->violations);
    }
}
