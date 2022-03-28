<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\AddShoppingItem\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\AddShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\AddShoppingItemRuleInterface;
use Lindyhopchris\ShoppingList\Application\Commands\AddShoppingItem\Validation\AddShoppingItemValidator;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AddShoppingItemValidatorTest extends TestCase
{
    /**
     * @var AddShoppingItemModel|MockObject
     */
    private AddShoppingItemModel|MockObject $model;

    /**
     * @var AddShoppingItemRuleInterface|MockObject
     */
    private AddShoppingItemRuleInterface|MockObject $rule1;

    /**
     * @var AddShoppingItemRuleInterface|MockObject
     */
    private AddShoppingItemRuleInterface|MockObject $rule2;

    /**
     * @var AddShoppingItemValidator
     */
    private AddShoppingItemValidator $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->model = $this->createMock(AddShoppingItemModel::class);

        $this->validator = new AddShoppingItemValidator(
            $this->rule1 = $this->createMock(AddShoppingItemRuleInterface::class),
            $this->rule2 = $this->createMock(AddShoppingItemRuleInterface::class),
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
        } catch (ValidationException $ex) {
            $this->assertSame('Invalid shopping item.', $ex->getMessage());
            $this->assertSame($expected, $ex->getMessages());
        }
    }
}
