<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Domain;

use JsonSerializable;
use UnexpectedValueException;

class Slug implements JsonSerializable
{
    /** @var string */
    private const REGEX = '/^[a-z][a-z\-]{2,}[a-z]$/';

    /**
     * @var string
     */
    private string $value;

    /**
     * Is the provided value a valid slug?
     *
     * @param mixed $value
     * @return bool
     */
    public static function isValid(mixed $value): bool
    {
        return is_string($value) &&
            0 < preg_match(self::REGEX, $value);
    }

    /**
     * Slug constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (false === self::isValid($value)) {
            throw new UnexpectedValueException('Expecting a valid slug.');
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Fluent to-string method.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
