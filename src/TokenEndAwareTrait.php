<?php

namespace Dhii\Output;

use Dhii\Util\String\StringableInterface as Stringable;
use InvalidArgumentException;

/**
 * Functionality for awareness of a token end delimiter.
 *
 * @since [*next-version*]
 */
trait TokenEndAwareTrait
{
    /**
     * @since [*next-version*]
     *
     * @var Stringable|string|int|float|bool|null
     */
    protected $tokenEnd;

    /**
     * Retrieves the token end delimiter.
     *
     * @since [*next-version*]
     *
     * @return Stringable|string|int|float|bool|null The delimiter
     */
    protected function _getTokenEnd()
    {
        return $this->tokenEnd;
    }

    /**
     * Assigns the token end delimiter.
     *
     * @since [*next-version*]
     *
     * @param Stringable|string|int|float|bool|null $delimiter The delimiter that marks the end of a token.
     *
     * @throws InvalidArgumentException If the delimiter is invalid.
     */
    protected function _setTokenEnd($delimiter)
    {
        if (!is_null($delimiter)) {
            $delimiter = $this->_normalizeTokenDelimiter($delimiter);
        }

        $this->tokenEnd = $delimiter;
    }

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
    abstract protected function _normalizeTokenDelimiter($delimiter);
}
