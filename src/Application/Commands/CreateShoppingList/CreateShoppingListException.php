<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList;

use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use LogicException;

class CreateShoppingListException extends LogicException
{
    /**
     * @var array
     */
    private array $messages = [];

    /**
     * @param ValidationMessageStack $result
     * @return static
     */
    public static function invalid(ValidationMessageStack $result): self
    {
        $ex = new self('Invalid shopping list.');
        $ex->messages = $result->getMessages();

        return $ex;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        if (!empty($this->messages)) {
            return $this->messages;
        }

        return [$this->getMessage()];
    }
}
