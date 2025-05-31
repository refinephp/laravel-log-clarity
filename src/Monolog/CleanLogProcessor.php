<?php

namespace Refinephp\LaravelLogClarity\Monolog;

use Illuminate\Support\Arr;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use Refinephp\LaravelLogClarity\Support\StackTraceFilter;

/**
 * Class CleanLogProcessor
 *
 * A Monolog processor that trims and cleans up stack traces
 * before they get formatted or written to a log channel.
 */
class CleanLogProcessor implements ProcessorInterface
{
    protected StackTraceFilter $filter;

    public function __construct()
    {
        $this->filter = new StackTraceFilter();
    }

    /**
     * This method is called for every log record.
     *
     * @param  \Monolog\LogRecord  $record
     * @return \Monolog\LogRecord
     */
    public function __invoke(LogRecord $record): LogRecord
    {
        // 1. Check if filtering is enabled in config
        if (! config('log-clarity.enabled')) {
            return $record;
        }

        // 2. Check if current environment is allowed
        if (! in_array(app()->environment(), (array) config('log-clarity.environments', []), true)) {
            return $record;
        }

        // 3. Check if current channel is in the allowed channels
        $channel = Arr::get($record->extra, 'channel', $record->channel);
        // Laravel 9+ attaches channel in $record->channel; older versions might attach it differently.

        if (! in_array($channel, (array) config('log-clarity.channels', []), true)) {
            return $record;
        }

        // 4. If there is an exception in the context, filter its trace
        $context = $record->context;

        if (isset($context['exception']) && $context['exception'] instanceof \Throwable) {
            $exception     = $context['exception'];
            $filteredTrace = $this->filter->filter($exception);

            // Replace the raw 'trace' in the context with our filtered version
            $record = $record->withContext([
                'exception' => $exception,            // keep the original exception object
                'filtered_trace' => $filteredTrace,   // new key containing only relevant frames
                // You may remove or leave the original 'trace' key if it exists; be explicit:
                'trace' => $filteredTrace,
            ]);
        }

        return $record;
    }
}
