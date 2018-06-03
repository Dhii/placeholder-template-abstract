<?php

namespace Dhii\Output;

use ArrayAccess;
use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface as BaseContainerInterface;
use Dhii\Util\String\StringableInterface as Stringable;
use Psr\Container\NotFoundExceptionInterface;
use Exception as RootException;
use RuntimeException;
use stdClass;

/**
 * Functionality for replacing tokens with corresponding values.
 *
 * @since [*next-version*]
 */
trait ReplaceTokensCapableTrait
{
    /**
     * Replaces all tokens in a string with corresponding values.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable                                 $input      The string that may contain tokens.
     * @param BaseContainerInterface|array|ArrayAccess|stdClass $source     The source of values for replacement.
     * @param string|Stringable                                 $tokenStart Starting delimiter of token.
     * @param string|Stringable                                 $tokenEnd   Ending delimiter of token.
     * @param string|Stringable|null                            $default    Default replacement value. Used if a token does not correspond to known value.
     *
     * @throws InvalidArgumentException If input, source, token start or end, or the default value are invalid.
     * @throws RuntimeException         If problem replacing tokens.
     *
     * @return string The resulting string.
     */
    protected function _replaceTokens($input, $source, $tokenStart, $tokenEnd, $default = null)
    {
        $input   = $this->_normalizeString($input);
        $default = $default === null ? '' : $this->_normalizeString($default);

        $regexDelimiter = '/';
        $tokenStart     = $this->_quoteRegex($tokenStart, $regexDelimiter);
        $tokenEnd       = $this->_quoteRegex($tokenEnd, $regexDelimiter);

        $regex   = $regexDelimiter . $tokenStart . '(.*?)' . $tokenEnd . $regexDelimiter;
        $matches = $this->_getAllMatchesRegex($regex, $input);

        foreach ($matches[0] as $i => $token) {
            $key = $matches[1][$i];
            $key = $this->_normalizeTokenKey($key);

            try {
                $value = $this->_containerGet($source, $key);
            } catch (NotFoundExceptionInterface $e) {
                $value = $default;
            } catch (RootException $e) {
                $this->_createRuntimeException($this->__('Could not access reference value for key "%1$s"', [$key]), null, $e);
            }

            try {
                $input = $this->_stringableReplace($token, $value, $input);
            } catch (RootException $e) {
                $this->_createRuntimeException($this->__('Could not replace token with key "%1$s"', [$key]), null, $e);
            }
        }

        return $input;
    }

    /**
     * Normalizes a key derived from a token.
     *
     * This is useful to convert a key from compatible formats into the format used in the container.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable $key The key to normalize.
     *
     * @throws InvalidArgumentException If the key could not be normalized.
     *
     * @return string|Stringable The normalized key.
     */
    abstract protected function _normalizeTokenKey($key);

    /**
     * Retrieves a value from a container or data set.
     *
     * @since [*next-version*]
     *
     * @param array|ArrayAccess|stdClass|BaseContainerInterface $container The container to read from.
     * @param string|int|float|bool|Stringable                  $key       The key of the value to retrieve.
     *
     * @throws InvalidArgumentException    If the container is invalid.
     * @throws ContainerExceptionInterface If an error occurred while reading from the container.
     * @throws NotFoundExceptionInterface  If the key was not found in the container.
     *
     * @return mixed The value mapped to the given key.
     */
    abstract protected function _containerGet($container, $key);

    /**
     * Replaces occurrences of needle in haystack.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable $search  The string to look for.
     * @param string|Stringable $replace The string to replace with.
     * @param string|Stringable $subject The string look in.
     *
     * @throw InvalidArgumentException If the needle, replacement, or haystack is invalid.
     * @throw RuntimeException If problem replacing.
     *
     * @return string The haystack with all occurrences of needle replaced.
     */
    abstract public function _stringableReplace($search, $replace, $subject);

    /**
     * Retrieves all matches that correspond to a RegEx pattern from a string.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable $pattern The RegEx pattern to use for matching.
     * @param string|Stringable $subject The subject that will be searched for matches.
     *
     * @throw InvalidArgumentException If the pattern or the subject are of the wrong type.
     * @throw RuntimeException If problem matching.
     *
     * @return array The array of matches. Format is same as the matches produced by `preg_match_all()`.
     */
    abstract protected function _getAllMatchesRegex($pattern, $subject);

    /**
     * Escapes special characters in a string such that it is interpreted literally by a PCRE parser.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable      $string    The string to quote.
     * @param string|Stringable|null $delimiter The delimiter that will be used in the expression, if any.
     *                                          If specified, this delimiter will be quoted too.
     *
     * @throws InvalidArgumentException If the string or the delimiter are invalid.
     *
     * @return string The quoted string.
     */
    abstract protected function _quoteRegex($string, $delimiter = null);

    /**
     * Normalizes a value to its string representation.
     *
     * The values that can be normalized are any scalar values, as well as
     * {@see StringableInterface).
     *
     * @since [*next-version*]
     *
     * @param Stringable|string|int|float|bool $subject The value to normalize to string.
     *
     * @throws InvalidArgumentException If the value cannot be normalized.
     *
     * @return string The string that resulted from normalization.
     */
    abstract protected function _normalizeString($subject);

    /**
     * Translates a string, and replaces placeholders.
     *
     * @since [*next-version*]
     * @see sprintf()
     *
     * @param string $string  The format string to translate.
     * @param array  $args    Placeholder values to replace in the string.
     * @param mixed  $context The context for translation.
     *
     * @return string The translated string.
     */
    abstract protected function __($string, $args = [], $context = null);

    /**
     * Creates a new Runtime exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable|int|float|bool|null $message  The message, if any.
     * @param int|float|string|Stringable|null      $code     The numeric error code, if any.
     * @param RootException|null                    $previous The inner exception, if any.
     *
     * @return RuntimeException The new exception.
     */
    abstract protected function _createRuntimeException($message = null, $code = null, $previous = null);
}
