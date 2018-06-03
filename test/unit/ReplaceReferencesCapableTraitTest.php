<?php

namespace Dhii\Output\UnitTest;

use Dhii\Output\ReplaceTokensCapableTrait as TestSubject;
use Psr\Container\NotFoundExceptionInterface;
use Xpmock\TestCase;
use Exception as RootException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_MockObject_MockBuilder as MockBuilder;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class ReplaceReferencesCapableTraitTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Output\ReplaceTokensCapableTrait';

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
     * Creates a new Not Found exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return MockObject|RootException|NotFoundExceptionInterface The new exception.
     */
    public function createNotFoundException($message = '')
    {
        $mock = $this->mockClassAndInterfaces('Exception', ['Psr\Container\NotFoundExceptionInterface'])
            ->setConstructorArgs([$message])
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
     * Tests whether `_replaceTokens()` works as expected.
     *
     * @since [*next-version*]
     */
    public function testReplaceReferences()
    {
        $rxDelim = '/';
        $tStart = '${';
        $tEnd = '}';
        $tTemplate = '%1$s%3$s%2$s';
        $fox = uniqid('fox');
        $dog = uniqid('dog');
        $tFox = vsprintf($tTemplate, [$tStart, $tEnd, $fox]);
        $tDog = vsprintf($tTemplate, [$tStart, $tEnd, $dog]);
        $vFox = 'Elizabeth';
        $vDog = 'Bruno';
        $source = [
            $fox => $vFox,
            $dog => $vDog,
        ];
        $default = 'rascal'; // :)
        $vDefault = preg_replace('/\w/', '*', $default);
        $tDefault = vsprintf($tTemplate, [$tStart, $tEnd, $default]);
        $inputTemplate = 'The quick brown %1$s jumped over the lazy %2$s; what a %3$s!';
        $input = vsprintf($inputTemplate, [$tFox, $tDog, $tDefault]);
        $keys = [
            $fox,
            $dog,
            $default,
        ];
        $tokens = [
            $tFox,
            $tDog,
            $tDefault,
        ];

        $subject = $this->createInstance(['_normalizeString', '_quoteRegex', '_getAllMatchesRegex', '_containerGet', '_normalizeTokenKey', '_stringableReplace']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(2))
            ->method('_normalizeString')
            ->withConsecutive([$input], [$vDefault])
            ->will($this->returnArgument(0));
        $subject->expects($this->exactly(2))
            ->method('_quoteRegex')
            ->withConsecutive([$tStart, $rxDelim], [$tEnd, $rxDelim])
            ->willReturnMap([
                [$tStart, $rxDelim, preg_quote($tStart, $rxDelim)],
                [$tEnd, $rxDelim, preg_quote($tEnd, $rxDelim)],
            ]);
        $subject->expects($this->exactly(1))
            ->method('_getAllMatchesRegex')
            ->with(
                $rxDelim.preg_quote($tStart, $rxDelim).'(.*?)'.preg_quote($tEnd, $rxDelim).$rxDelim,
                $input
            )
            ->will($this->returnValue([
                // Full pattern matches
                [
                    $tFox,
                    $tDog,
                    $tDefault,
                ],
                // First group matches
                $keys,
            ]));
        // Key normalization can simply return the key, because here we expect them in the same format as they appear in the template.
        $subject->expects($this->exactly(count($keys)))
            ->method('_normalizeTokenKey')
            ->withConsecutive(
                [$keys[0]],
                [$keys[1]],
                [$keys[2]]
            )
            ->will($this->returnArgument(0));
        $subject->expects($this->exactly(count($keys)))
            ->method('_containerGet')
            ->withConsecutive(
                [$source, $keys[0]],
                [$source, $keys[1]],
                [$source, $keys[2]]
            )
            ->will($this->returnCallback(function ($source, $key) {
                if (!isset($source[$key])) {
                    throw $this->createNotFoundException(sprintf('Key "%1$s" not found', $key));
                }

                return $source[$key];
            }));
        $subject->expects($this->exactly(count($keys)))
            ->method('_stringableReplace')
            ->withConsecutive(
                [$tokens[0], $source[$keys[0]]],
                [$tokens[1], $source[$keys[1]]],
                [$tokens[2], $vDefault]
            )
            ->will($this->returnCallback(function ($search, $replace, $input) {
                return str_replace($search, $replace, $input);
            }));

        $result = $_subject->_replaceTokens($input, $source, $tStart, $tEnd, $vDefault);
        $this->assertEquals(vsprintf($inputTemplate, [$source[$fox], $source[$dog], $vDefault]), $result, 'Wrong replacement result');
    }
}
