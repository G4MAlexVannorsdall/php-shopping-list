<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Commands\TickOffShoppingItem\Validation;

use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\TickOffShoppingItemModel;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation\TickOffShoppingItemRuleInterface;
use Lindyhopchris\ShoppingList\Application\Commands\TickOffShoppingItem\Validation\TickOffShoppingItemValidator;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationException;
use Lindyhopchris\ShoppingList\Common\Validation\ValidationMessageStack;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TickOffShoppingItemValidatorTest extends TestCase
{
    /**
     * @var TickOffShoppingItemModel|MockObject
     */
    private TickOffShoppingItemModel|MockObject $model;

    /**
     * @var TickOffShoppingItemRuleInterface|MockObject
     */
    private TickOffShoppingItemRuleInterface|MockObject $rule1;

    /**
     * @var TickOffShoppingItemRuleInterface|MockObject
     */
    private TickOffShoppingItemRuleInterface|MockObject $rule2;

    /**
     * @var TickOffShoppingItemValidator
     */
    private TickOffShoppingItemValidator $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->model = $this->createMock(TickOffShoppingItemModel::class);

        $this->validator = new TickOffShoppingItemValidator(
            $this->rule1 = $this->createMock(TickOffShoppingItemRuleInterface::class),
            $this->rule2 = $this->createMock(TickOffShoppingItemRuleInterface::class),
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
            $this->assertSame('Invalid shopping item to tick off.', $ex->getMessage());
            $this->assertSame($expected, $ex->getMessages());
        }
    }
}
