<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable or Disable Log Clarity
    |--------------------------------------------------------------------------
    |
    | Set this to false if you want to completely turn off log filtering.
    | You might disable it in local or testing environments, for example.
    |
    */
    'enabled' => env('LOG_CLARITY_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Include / Exclude Paths
    |--------------------------------------------------------------------------
    |
    | This allows you to specify which filesystem paths should be included
    | or excluded when trimming stack traces. By default, everything in `app/`
    | is included, and everything in `vendor/` or `bootstrap/` is excluded.
    |
    */
    'include_paths' => [
        'app/',
    ],

    'exclude_paths' => [
        'vendor/',
        'bootstrap/',
    ],

    /*
    |--------------------------------------------------------------------------
    | Maximum Stack Trace Length
    |--------------------------------------------------------------------------
    |
    | If a stack trace has hundreds of frames, trim it down to this length.
    | Set to `null` for no limit, or an integer to limit the number of frames.
    |
    */
    'max_stack_length' => 50,

    /*
    |--------------------------------------------------------------------------
    | Filtered Environments
    |--------------------------------------------------------------------------
    |
    | Only apply Log Clarity when the app environment matches one of these.
    | Example: local, testing, production, staging.
    |
    */
    'environments' => [
        'production',
        'staging',
    ],

    /*
    |--------------------------------------------------------------------------
    | Channels to Apply On
    |--------------------------------------------------------------------------
    |
    | Only apply log trimming on these channels. Example: stack, daily, single.
    |
    */
    'channels' => [
        'stack',
        'daily',
    ],

];
