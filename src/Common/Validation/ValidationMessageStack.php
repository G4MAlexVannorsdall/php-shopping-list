<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Common\Validation;

class ValidationMessageStack
{
    /**
     * @var string[]
     */
    private array $messages;

    /**
     * CreateShoppingListValidatorResult constructor
     *
     * @param array|null $messages
     */
    public function __construct(array $messages = null)
    {
        $this->messages = [];

        if (null !== $messages) {
            $this->addMessages($messages);
        }
    }

    /**
     * @param array $messages
     * @return $this
     */
    public function addMessages(array $messages): self
    {
        foreach ($messages as $message) {
            $this->addMessage($message);
        }

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function addMessage(string $message): self
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * @param ValidationMessageStack $other
     * @return $this
     */
    public function merge(self $other): self
    {
        $this->messages = array_merge($this->messages, $other->messages);

        return $this;
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->messages);
    }
}
