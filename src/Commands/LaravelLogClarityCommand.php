<?php

namespace Refinephp\LaravelLogClarity\Commands;

use Illuminate\Console\Command;

class LaravelLogClarityCommand extends Command
{
    public $signature = 'laravel-log-clarity';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
