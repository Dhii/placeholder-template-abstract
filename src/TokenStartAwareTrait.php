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
     * @var string|Stringable|null
     */
    protected $tokenStart;

    /**
     * Retrieves the token start delimiter.
     *
     * @since [*next-version*]
     *
     * @return string|Stringable|null The delimiter.
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
     * @param string|Stringable|null $delimiter The delimiter that marks the start of a token.
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
     * @param string|Stringable $delimiter The token delimiter to normalize.
     *
     * @throws InvalidArgumentException If the token delimiter could not be normalized.
     *
     * @return string|Stringable The normalized token.
     */
    abstract protected function _normalizeTokenDelimiter($delimiter);
}
