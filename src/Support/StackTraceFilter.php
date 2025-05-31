<?php

namespace Refinephp\LaravelLogClarity\Support;

use Throwable;

/**
 * Class StackTraceFilter
 *
 * Responsible for trimming a Throwable's stack trace
 * according to the package configuration.
 */
class StackTraceFilter
{
    /**
     * @var array<string>
     */
    protected array $includePaths;

    /**
     * @var array<string>
     */
    protected array $excludePaths;

    /**
     * @var int|null
     */
    protected ?int $maxStackLength;

    public function __construct()
    {
        $config = config('log-clarity');

        $this->includePaths   = $config['include_paths'] ?? ['app/'];
        $this->excludePaths   = $config['exclude_paths'] ?? ['vendor/', 'bootstrap/'];
        $this->maxStackLength = $config['max_stack_length'];
    }

    /**
     * Filter the given Throwable's trace to only include frames
     * matching includePaths, and not matching excludePaths.
     *
     * @param  \Throwable  $exception
     * @return array<int, array<string, mixed>>  // Simplified frame array
     */
    public function filter(Throwable $exception): array
    {
        $rawTrace = $exception->getTrace();

        $filtered = [];

        foreach ($rawTrace as $frame) {
            $file = $frame['file'] ?? null;

            if (! $file) {
                // If there's no file (e.g., internal PHP call), skip or include based on config.
                continue;
            }

            if ($this->shouldIncludeFrame($file)) {
                // Keep only relevant frame keys (file, line, function, class, args)
                $filtered[] = [
                    'file'     => $file,
                    'line'     => $frame['line'] ?? null,
                    'class'    => $frame['class'] ?? null,
                    'function' => $frame['function'] ?? null,
                ];

                // If we've reached max length, break out
                if (is_int($this->maxStackLength) && count($filtered) >= $this->maxStackLength) {
                    break;
                }
            }
        }

        return $filtered;
    }

    /**
     * Determine if a given file path should be included based on include/exclude rules.
     *
     * @param  string  $filePath
     * @return bool
     */
    protected function shouldIncludeFrame(string $filePath): bool
    {
        // Exclude first if any exclude path appears in the full path
        foreach ($this->excludePaths as $exclude) {
            if (str_contains($filePath, $exclude)) {
                return false;
            }
        }

        // Then check include: if ANY include path is found, keep it
        foreach ($this->includePaths as $include) {
            if (str_contains($filePath, $include)) {
                return true;
            }
        }

        // If no include path matched, we skip this frame.
        return false;
    }
}
