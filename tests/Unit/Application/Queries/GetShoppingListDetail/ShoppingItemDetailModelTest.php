<?php
declare(strict_types=1);

namespace Tests\Unit\Application\Queries\GetShoppingListDetail;

use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail\ShoppingItemDetailModel;
use PHPUnit\Framework\TestCase;

class ShoppingItemDetailModelTest extends TestCase
{
    public function test(): void
    {
        $model = new ShoppingItemDetailModel(1, 'Apples', true);

        $this->assertSame(1, $model->getId());
        $this->assertSame('Apples', $model->getName());
        $this->assertTrue($model->isCompleted());
    }
}
