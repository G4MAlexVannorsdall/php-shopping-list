<?php

namespace Tests\Unit\Application\Commands\DeleteShoppingItem\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\DeleteShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\DeleteShoppingItemRuleInterface;
use Lindyhopchris\ShoppingList\Application\Commands\DeleteShoppingItem\Validation\DeleteShoppingItemValidator;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteShoppingItemValidatorTest extends TestCase
{
    /**
     * @var DeleteShoppingItemModel|MockObject
     */
    private DeleteShoppingItemModel|MockObject $model;

    /**
     * @var DeleteShoppingItemRuleInterface|MockObject
     */
    private DeleteShoppingItemRuleInterface|MockObject $rule1;

    /**
     * @var DeleteShoppingItemRuleInterface|MockObject
     */
    private DeleteShoppingItemRuleInterface|MockObject $rule2;

    /**
     * @var DeleteShoppingItemValidator
     */
    private DeleteShoppingItemValidator $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->model = $this->createMock( DeleteShoppingItemModel::class);

        $this->validator = new DeleteShoppingItemValidator(
            $this->rule1 = $this->createMock(DeleteShoppingItemRuleInterface::class),
            $this->rule2 = $this->createMock(DeleteShoppingItemRuleInterface::class),
        );
    }

    public function testItIsValid(): void
    {
        $this->rule1
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack());

        $this->rule2
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack());

        $messages = $this->validator->validate($this->model);

        $this->assertFalse($messages->hasErrors());
    }

    public function testItIsInvalid(): void
    {
        $this->rule1
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack($expected = ['There is an error.']));

        $this->rule2
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack());

        $actual = $this->validator->validate($this->model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame($expected, $actual->getMessages());
    }

    public function testItDoesNotThrowIfValid(): void
    {
        $this->rule1
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack());

        $this->rule2
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack());

        $this->validator->validateOrFail($this->model);
    }

    public function testItThrowsIfInvalid(): void
    {
        $this->rule1
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack());

        $this->rule2
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack($expected = ['It is invalid.']));

        try {
            $this->validator->validateOrFail($this->model);
            $this->fail('No exception thrown.');
        } catch (ValidationException $ex) {
            $this->assertSame('Invalid shopping item to delete.', $ex->getMessage());
            $this->assertSame($expected, $ex->getMessages());
        }
    }
}
