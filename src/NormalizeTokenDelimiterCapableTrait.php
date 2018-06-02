<?php

namespace Dhii\Output;

use Dhii\Util\String\StringableInterface as Stringable;
use Exception as RootException;
use InvalidArgumentException;

/**
 * Functionality for token delimiter normalization.
 *
 * @since [*next-version*]
 */
trait NormalizeTokenDelimiterCapableTrait
{
    /**
     * Normalizes a token delimiter.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable $delimiter The token delimiter to normalize.
     *
     * @throws InvalidArgumentException If the token delimiter could not be normalized.
     *
     * @return string|Stringable The normalized token.
     */
    protected function _normalizeTokenDelimiter($delimiter)
    {
        if (!($delimiter instanceof Stringable) && !is_string($delimiter)) {
            throw $this->_createInvalidArgumentException($this->__('Invalid token delimiter'), null, null, $delimiter);
        }

        return $delimiter;
    }

    /**
     * Creates a new Invalid Argument exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable|int|float|bool|null $message  The message, if any.
     * @param int|float|string|Stringable|null      $code     The numeric error code, if any.
     * @param RootException|null                    $previous The inner exception, if any.
     * @param mixed|null                            $argument The invalid argument, if any.
     *
     * @return InvalidArgumentException The new exception.
     */
    abstract protected function _createInvalidArgumentException(
        $message = null,
        $code = null,
        RootException $previous = null,
        $argument = null
    );

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
}
