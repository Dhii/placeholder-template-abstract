<?php

namespace Dhii\Output;

use Dhii\Util\String\StringableInterface as Stringable;
use InvalidArgumentException;

/**
 * Functionality for awareness of a placeholder template.
 *
 * @since [*next-version*]
 */
trait PlaceholderTemplateAwareCapableTrait
{
    /**
     * The placeholder template.
     *
     * @since [*next-version*]
     *
     * @var Stringable|string|int|float|bool|null
     */
    protected $placeholderTemplate;

    /**
     * Assigns the placeholder template to this instance.
     *
     * @since [*next-version*]
     *
     * @param Stringable|string|int|float|bool|null $template The template.
     */
    protected function _setPlaceholderTemplate($template)
    {
        if (!is_null($template)) {
            $template = $this->_normalizeStringable($template);
        }

        $this->placeholderTemplate = $template;
    }

    /**
     * Retrieves the placeholder template associated with this instance.
     *
     * This template is something that can be converted to string, and may contain placeholders.
     *
     * @since [*next-version*]
     *
     * @return Stringable|string|int|float|bool|null The placeholder template.
     */
    protected function _getPlaceholderTemplate()
    {
        return $this->placeholderTemplate;
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
