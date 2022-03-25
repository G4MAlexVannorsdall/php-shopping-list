<?php
declare(strict_types=1);

namespace Tests\Unit\Common\Validation;

use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use PHPUnit\Framework\TestCase;

class ValidationMessageStackTest extends TestCase
{
    public function testEmpty(): void
    {
        $messages = new ValidationMessageStack();

        $this->assertFalse($messages->hasErrors());
        $this->assertEmpty($messages->getMessages());
    }

    public function testConstructWithMessages(): ValidationMessageStack
    {
        $messages = new ValidationMessageStack($expected = [
            'Message 1',
            'Message 2',
        ]);

        $this->assertSame($expected, $messages->getMessages());

        return $messages;
    }

    /**
     * @param ValidationMessageStack $messages
     * @return void
     * @depends testConstructWithMessages
     */
    public function testAddMessages(ValidationMessageStack $messages): void
    {
        $actual = $messages->addMessages([
            'Message 3',
            'Message 4',
        ]);

        $this->assertSame($messages, $actual);
        $this->assertSame([
            'Message 1',
            'Message 2',
            'Message 3',
            'Message 4',
        ], $actual->getMessages());
    }

    public function testMerge(): void
    {
        $messages1 = new ValidationMessageStack(['Message 1', 'Message 2']);
        $messages2 = new ValidationMessageStack(['Message 3', 'Message 4']);

        $actual = $messages1->merge($messages2);

        $this->assertSame($messages1, $actual);
        $this->assertSame([
            'Message 1',
            'Message 2',
            'Message 3',
            'Message 4',
        ], $actual->getMessages());
    }
}
