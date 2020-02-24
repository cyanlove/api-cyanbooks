<?php declare(strict_types = 1);

namespace CyanBooks\Test\Book\Shared;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

abstract class TestCase extends PHPUnitTestCase
{
    use MockeryPHPUnitIntegration;

    public function mock(string $class): MockInterface
    {
        return Mockery::mock($class);
    }

    public function similarTo($arguments)
    {
        return \Hamcrest\Matchers::equalTo($arguments);
    }
}
