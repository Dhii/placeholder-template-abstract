<?php

namespace Dhii\Output;

use Dhii\Util\String\StringableInterface as Stringable;
use InvalidArgumentException;

/**
 * Functionality for awareness of a default placeholder value.
 *
 * @since [*next-version*]
 */
trait DefaultPlaceholderValueAwareTrait
{
    /**
     * The default placeholder value.
     *
     * @since [*next-version*]
     *
     * @var Stringable|string|int|float|bool|null
     */
    protected $defaultPlaceholderValue;

    /**
     * Retrieves the default placeholder value associated with this instance.
     *
     * @since [*next-version*]
     *
     * @return Stringable|string|int|float|bool|null The default value.
     */
    protected function _getDefaultPlaceholderValue()
    {
        return $this->defaultPlaceholderValue;
    }

    /**
     * Assigns a default placeholder value to this instance.
     *
     * @since [*next-version*]
     *
     * @param Stringable|string|int|float|bool $value The default value.
     *
     * @throws InvalidArgumentException If value is invalid.
     */
    protected function _setDefaultPlaceholderValue($value)
    {
        if (!is_null($value)) {
            $value = $this->_normalizeStringable($value);
        }

        $this->defaultPlaceholderValue = $value;
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
