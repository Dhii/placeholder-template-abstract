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
     * @param Stringable|string|int|float|bool $delimiter The token delimiter to normalize.
     *
     * @throws InvalidArgumentException If the token delimiter could not be normalized.
     *
     * @return Stringable|string|int|float|bool The normalized token.
     */
    protected function _normalizeTokenDelimiter($delimiter)
    {
        $delimiter = $this->_normalizeStringable($delimiter);

        return $delimiter;
    }

    /**
     * Normalizes a stringable value.
     *
     * Useful to make sure that a value can be converted to string in a meaningful way.
     *
     * @since [*next-version*]
     *
     * @param Stringable|string|int|float|bool $stringable The value to normalize.
     *                                                     Can be an object that implements {@see Stringable}, or scalar type -
     *                                                     basically anything that can be converted to a string in a meaningful way.
     *
     * @throws InvalidArgumentException If the value could not be normalized.
     *
     * @return Stringable|string|int|float|bool The normalized stringable.
     *                                          If the original value was stringable, that same value will be returned without any modification.
     */
    abstract protected function _normalizeStringable($stringable);
}
