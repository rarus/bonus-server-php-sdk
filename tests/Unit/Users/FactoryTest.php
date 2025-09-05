<?php

declare(strict_types=1);

namespace Rarus\LMS\SDK\Tests\Unit\Users;

use PHPUnit\Framework\TestCase;
use Rarus\LMS\SDK\Exceptions\InvalidArgumentException;
use Rarus\LMS\SDK\Users\DTO\Factory;

/**
 * Class FactoryTest
 *
 * Tests the __call method in the Factory class. The __call method is responsible
 * for dynamically assigning property values based on the method name prefixed
 * with "with". It should handle valid dynamic method calls gracefully and throw
 * exceptions for invalid method calls.
 */
class FactoryTest extends TestCase
{
    /**
     * Test that __call sets properties correctly using a valid dynamic method call.
     */
    public function test_call_with_valid_method(): void
    {
        $factory = Factory::create();
        $updatedFactory = $factory->withName('John Doe');

        $reflection = new \ReflectionClass($updatedFactory);
        $properties = $reflection->getProperty('properties');
        $properties->setAccessible(true);

        $this->assertArrayHasKey('name', $properties->getValue($updatedFactory));
        $this->assertSame('John Doe', $properties->getValue($updatedFactory)['name']);
    }

    public function test_call_create_object(): void
    {
        $userDto1 = Factory::create()
            ->withName('John Doe')
            ->withPhone('123123')
            ->build();
        $userDto2 = Factory::fromDto($userDto1)
            ->withName('John Doe2')
            ->build();

        $this->assertNotSame($userDto1, $userDto2);
    }

    /**
     * Test that __call correctly handles multiple dynamic method calls.
     */
    public function test_call_with_multiple_valid_methods(): void
    {
        $factory = Factory::create();
        $updatedFactory = $factory->withName('John Doe')->withEmail('john.doe@example.com')->withPhone('1234567890');

        $reflection = new \ReflectionClass($updatedFactory);
        $properties = $reflection->getProperty('properties');
        $properties->setAccessible(true);

        $props = $properties->getValue($updatedFactory);

        $this->assertArrayHasKey('name', $props);
        $this->assertArrayHasKey('email', $props);
        $this->assertArrayHasKey('phone', $props);

        $this->assertSame('John Doe', $props['name']);
        $this->assertSame('john.doe@example.com', $props['email']);
        $this->assertSame('1234567890', $props['phone']);
    }

    /**
     * Test that __call throws an InvalidArgumentException when an invalid method is called.
     */
    public function test_call_with_invalid_method(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Method invalidMethod does not exist');

        $factory = Factory::create();
        // @phpstan-ignore-next-line
        $factory->invalidMethod('some value');
    }

    /**
     * Test that __call handles a method call with no arguments, setting the value to null.
     */
    public function test_call_with_no_arguments(): void
    {
        $factory = Factory::create();

        // @phpstan-ignore-next-line
        $updatedFactory = $factory->withEmail();

        $reflection = new \ReflectionClass($updatedFactory);
        $properties = $reflection->getProperty('properties');
        $properties->setAccessible(true);

        $this->assertArrayHasKey('email', $properties->getValue($updatedFactory));
        $this->assertNull($properties->getValue($updatedFactory)['email']);
    }

    /**
     * Test that __call handles a chain of valid method calls that override previous values.
     */
    public function test_call_overwriting_values(): void
    {
        $factory = Factory::create();
        $updatedFactory = $factory->withName('Jane Doe')->withName('John Doe');

        $reflection = new \ReflectionClass($updatedFactory);
        $properties = $reflection->getProperty('properties');
        $properties->setAccessible(true);

        $this->assertArrayHasKey('name', $properties->getValue($updatedFactory));
        $this->assertSame('John Doe', $properties->getValue($updatedFactory)['name']);
    }
}
