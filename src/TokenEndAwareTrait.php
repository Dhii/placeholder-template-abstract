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
     * @var string|Stringable|null
     */
    protected $tokenEnd;

    /**
     * Retrieves the token end delimiter.
     *
     * @since [*next-version*]
     *
     * @return string|Stringable|null The delimiter
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
     * @param string|Stringable|null $delimiter The delimiter that marks the end of a token.
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
     * @param string|Stringable $delimiter The token delimiter to normalize.
     *
     * @throws InvalidArgumentException If the token delimiter could not be normalized.
     *
     * @return string|Stringable The normalized token.
     */
    abstract protected function _normalizeTokenDelimiter($delimiter);
}
