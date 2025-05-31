<?php

namespace Refinephp\LaravelLogClarity\Services;

use Throwable;
use Refinephp\LaravelLogClarity\Support\StackTraceFilter;

/**
 * Class LogClarityService
 *
 * Public API for on-demand cleaning of exceptions
 * (in addition to the Monolog processor).
 */
class LogClarityService
{
    protected StackTraceFilter $filter;

    public function __construct()
    {
        $this->filter = new StackTraceFilter();
    }

    /**
     * Given a Throwable, return a filtered trace array
     *
     * @param  \Throwable  $exception
     * @return array<int, array<string, mixed>>
     */
    public function cleanThrowable(Throwable $exception): array
    {
        return $this->filter->filter($exception);
    }
}
