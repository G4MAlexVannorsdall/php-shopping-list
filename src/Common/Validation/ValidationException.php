<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Common\Validation;

use LogicException;

class ValidationException extends LogicException
{
    /**
     * @var ValidationMessageStack
     */
    private ValidationMessageStack $messages;

    /**
     * @param ValidationMessageStack $messages
     * @param string|null $message
     */
    public function __construct(ValidationMessageStack $messages, string $message = null)
    {
        parent::__construct($message ?? 'Invalid');
        $this->messages = $messages;
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages->getMessages();
    }
}
