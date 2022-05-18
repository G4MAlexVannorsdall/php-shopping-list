<?php

namespace Tests\Unit\Domain\ValueObjects;

use Lindyhopchris\ShoppingList\Domain\ValueObjects\ShoppingItemFilterEnum;
use PHPUnit\Framework\TestCase;

class ShoppingItemFilterEnumTest extends TestCase
{
    public function testConstructorValidatesArgument(): void
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage('This was not a valid search.');
        new ShoppingItemFilterEnum('XYZ');

    }

    public function testEnumCanBeConstructedWithValidArguments(): void
    {
        $validArgument= new ShoppingItemFilterEnum(ShoppingItemFilterEnum::ALL);

        self::assertInstanceOf(ShoppingItemFilterEnum::class, $validArgument);
    }

    public function testItGetsAllItems(): void
    {
        $allItems = new ShoppingItemFilterEnum(ShoppingItemFilterEnum::ALL);
        self::assertEquals(true, $allItems->all());

    }

    public function testItGetsOnlyCompletedItems(): void
    {
        $onlyCompletedItems = new ShoppingItemFilterEnum(ShoppingItemFilterEnum::ONLY_COMPLETED);
        self::assertEquals(true, $onlyCompletedItems->onlyCompleted());
    }

    public function testItGetsOnlyNotCompletedItems(): void
    {
        $onlyNotCompletedItems = new ShoppingItemFilterEnum(ShoppingItemFilterEnum::ONLY_NOT_COMPLETED);
        self::assertEquals(true, $onlyNotCompletedItems->onlyNotCompleted());
    }

}
