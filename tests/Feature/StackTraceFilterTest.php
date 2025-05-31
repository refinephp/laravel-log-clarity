<?php

namespace Refinephp\LaravelLogClarity\Tests\Feature;

use Refinephp\LaravelLogClarity\Support\StackTraceFilter;
use Throwable;

/*
 * Because we set default config values in TestCase::defineEnvironment(),
 * we no longer need to call config()->set(...) here—those values are already loaded.
 */

it('filters a thrown exception to include only test files', function () {
    // Create a fake exception with a custom trace (containing “tests/” and “vendor/” frames)
    $fakeTrace = [
        ['file' => __DIR__ . '/StackTraceFilterTest.php', 'line' => 10, 'class' => null, 'function' => 'testFunction'],
        ['file' => base_path('vendor/laravel/framework/src/SomeFile.php'), 'line' => 20, 'class' => 'SomeClass', 'function' => 'someMethod'],
        ['file' => __DIR__ . '/AnotherTestFile.php', 'line' => 30, 'class' => 'MyClass', 'function' => 'anotherMethod'],
    ];

    // Use Reflection to inject our fake trace into an Exception instance
    $reflectionException = new \ReflectionClass(Throwable::class);
    $exceptionInstance = $reflectionException->newInstanceWithoutConstructor();
    $traceProperty = $reflectionException->getProperty('trace');
    $traceProperty->setAccessible(true);
    $traceProperty->setValue($exceptionInstance, $fakeTrace);

    // Run the filter
    $filter = new StackTraceFilter();
    $result = $filter->filter($exceptionInstance);

    // We expect only the frames whose file path contains "tests/"
    expect($result)->toHaveCount(2);
    expect($result[0]['file'])->toContain('StackTraceFilterTest.php');
    expect($result[1]['file'])->toContain('AnotherTestFile.php');
});
