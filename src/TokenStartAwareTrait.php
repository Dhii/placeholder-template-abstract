<?php

namespace Dhii\Output;

use Dhii\Util\String\StringableInterface as Stringable;
use InvalidArgumentException;

/**
 * Functionality for awareness of a token start delimiter.
 *
 * @since [*next-version*]
 */
trait TokenStartAwareTrait
{
    /**
     * @since [*next-version*]
     *
     * @var Stringable|string|int|float|bool|null
     */
    protected $tokenStart;

    /**
     * Retrieves the token start delimiter.
     *
     * @since [*next-version*]
     *
     * @return Stringable|string|int|float|bool|null The delimiter.
     */
    protected function _getTokenStart()
    {
        return $this->tokenStart;
    }

    /**
     * Assigns the token start delimiter.
     *
     * @since [*next-version*]
     *
     * @param Stringable|string|int|float|bool|null $delimiter The delimiter that marks the start of a token.
     *
     * @throws InvalidArgumentException If the delimiter is invalid.
     */
    protected function _setTokenStart($delimiter)
    {
        if (!is_null($delimiter)) {
            $delimiter = $this->_normalizeTokenDelimiter($delimiter);
        }

        $this->tokenStart = $delimiter;
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
