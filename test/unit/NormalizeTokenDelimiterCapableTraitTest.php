<?php

namespace Dhii\Output\UnitTest;

use Dhii\Output\NormalizeTokenDelimiterCapableTrait as TestSubject;
use Dhii\Util\String\StringableInterface as Stringable;
use stdClass;
use Xpmock\TestCase;
use Exception as RootException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_MockObject_MockBuilder as MockBuilder;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class NormalizeTokenDelimiterCapableTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Output\NormalizeTokenDelimiterCapableTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array $methods The methods to mock.
     *
     * @return MockObject The new instance.
     */
    public function createInstance($methods = [])
    {
        is_array($methods) && $methods = $this->mergeValues($methods, [
            '__',
        ]);

        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods)
            ->getMockForTrait();

        $mock->method('__')
            ->will($this->returnArgument(0));

        return $mock;
    }

    /**
     * Merges the values of two arrays.
     *
     * The resulting product will be a numeric array where the values of both inputs are present, without duplicates.
     *
     * @since [*next-version*]
     *
     * @param array $destination The base array.
     * @param array $source      The array with more keys.
     *
     * @return array The array which contains unique values
     */
    public function mergeValues($destination, $source)
    {
        return array_keys(array_merge(array_flip($destination), array_flip($source)));
    }

    /**
     * Creates a mock that both extends a class and implements interfaces.
     *
     * This is particularly useful for cases where the mock is based on an
     * internal class, such as in the case with exceptions. Helps to avoid
     * writing hard-coded stubs.
     *
     * @since [*next-version*]
     *
     * @param string   $className      Name of the class for the mock to extend.
     * @param string[] $interfaceNames Names of the interfaces for the mock to implement.
     *
     * @return MockBuilder The builder for a mock of an object that extends and implements
     *                     the specified class and interfaces.
     */
    public function mockClassAndInterfaces($className, $interfaceNames = [])
    {
        $paddingClassName = uniqid($className);
        $definition = vsprintf('abstract class %1$s extends %2$s implements %3$s {}', [
            $paddingClassName,
            $className,
            implode(', ', $interfaceNames),
        ]);
        eval($definition);

        return $this->getMockBuilder($paddingClassName);
    }

    /**
     * Creates a mock that uses traits.
     *
     * This is particularly useful for testing integration between multiple traits.
     *
     * @since [*next-version*]
     *
     * @param string[] $traitNames Names of the traits for the mock to use.
     *
     * @return MockBuilder The builder for a mock of an object that uses the traits.
     */
    public function mockTraits($traitNames = [])
    {
        $paddingClassName = uniqid('Traits');
        $definition = vsprintf('abstract class %1$s {%2$s}', [
            $paddingClassName,
            implode(
                ' ',
                array_map(
                    function ($v) {
                        return vsprintf('use %1$s;', [$v]);
                    },
                    $traitNames)),
        ]);
        var_dump($definition);
        eval($definition);

        return $this->getMockBuilder($paddingClassName);
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return RootException|MockObject The new exception.
     */
    public function createException($message = '')
    {
        $mock = $this->getMockBuilder('Exception')
            ->setConstructorArgs([$message])
            ->getMock();

        return $mock;
    }

    /**
     * Creates a new Invalid Argument exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return RootException|MockObject The new exception.
     */
    public function createInvalidArgumentException($message = '')
    {
        $mock = $this->getMockBuilder('InvalidArgumentException')
            ->setConstructorArgs([$message])
            ->getMock();

        return $mock;
    }

    /**
     * Creates a new Stringable.
     *
     * @since [*next-version*]
     *
     * @param array|null $methods The methods to mock, if any.
     *
     * @return MockObject|Stringable The new stringable.
     */
    public function createStringable($methods = [])
    {
        is_array($methods) && $methods = $this->mergeValues($methods, [
            '__toString',
        ]);

        $mock = $this->getMockBuilder('Dhii\Util\String\StringableInterface')
            ->setMethods($methods)
            ->getMock();

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInternalType(
            'object',
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests whether `_normalizeTokenDelimiter()` works as expected.
     *
     * @since [*next-version*]
     */
    public function testNormalizeTokenDelimiterSuccessString()
    {
        $token = uniqid('token');
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $result = $_subject->_normalizeTokenDelimiter($token);
        $this->assertEquals($token, $result, 'String token normalization produced wrong result');
    }

    /**
     * Tests whether `_normalizeTokenDelimiter()` works as expected.
     *
     * @since [*next-version*]
     */
    public function testNormalizeTokenDelimiterSuccessStringable()
    {
        $value = uniqid('token');
        $token = $this->createStringable(['__toString']);
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $token->expects($this->any())
            ->method('__toString')
            ->will($this->returnValue($value));

        $result = $_subject->_normalizeTokenDelimiter($token);
        $this->assertEquals($value, (string) $result, 'Stringable token normalization produced wrong result');
    }

    /**
     * Tests whether `_normalizeTokenDelimiter()` fails as expected when given a non-stringable object.
     *
     * @since [*next-version*]
     */
    public function testNormalizeTokenDelimiterFailureObject()
    {
        $token = new stdClass();
        $exception = $this->createInvalidArgumentException('Invalid token');
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_createInvalidArgumentException')
            ->with(
                $this->isType('string'),
                $this->anything(),
                $this->anything(),
                $token
            )
            ->will($this->returnValue($exception));

        $this->setExpectedException('InvalidArgumentException');
        $result = $_subject->_normalizeTokenDelimiter($token);
    }
}