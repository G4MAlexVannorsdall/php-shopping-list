<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\CreateShoppingList\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListException;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\CreateShoppingListModel;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\CreateShoppingListRuleInterface;
use Lindyhopchris\ShoppingList\Application\Commands\CreateShoppingList\Validation\CreateShoppingListValidator;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateShoppingListValidatorTest extends TestCase
{
    /**
     * @var CreateShoppingListModel|MockObject
     */
    private CreateShoppingListModel|MockObject $model;

    /**
     * @var CreateShoppingListRuleInterface|MockObject
     */
    private CreateShoppingListRuleInterface|MockObject $rule1;

    /**
     * @var CreateShoppingListRuleInterface|MockObject
     */
    private CreateShoppingListRuleInterface|MockObject $rule2;

    /**
     * @var CreateShoppingListValidator
     */
    private CreateShoppingListValidator $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->model = $this->createMock(CreateShoppingListModel::class);

        $this->validator = new CreateShoppingListValidator(
            $this->rule1 = $this->createMock(CreateShoppingListRuleInterface::class),
            $this->rule2 = $this->createMock(CreateShoppingListRuleInterface::class),
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

    public function testItIsInvalidWithMultipleMessages(): void
    {
        $this->rule1
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack(['Message 1']));

        $this->rule2
            ->expects($this->once())
            ->method('validate')
            ->with($this->identicalTo($this->model))
            ->willReturn(new ValidationMessageStack(['Message 2']));

        $actual = $this->validator->validate($this->model);

        $this->assertTrue($actual->hasErrors());
        $this->assertSame(['Message 1', 'Message 2'], $actual->getMessages());
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
        } catch (CreateShoppingListException $ex) {
            $this->assertSame('Invalid shopping list.', $ex->getMessage());
            $this->assertSame($expected, $ex->getMessages());
        }
    }
}
