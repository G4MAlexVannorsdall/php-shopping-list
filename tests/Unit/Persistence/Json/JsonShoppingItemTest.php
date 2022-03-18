<?php
declare(strict_types=1);

namespace Tests\Unit\Persistence\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingItem;
use PHPUnit\Framework\TestCase;

class JsonShoppingItemTest extends TestCase
{
    public function test(): void
    {
        $expected = <<<JSON
{
    "item": {
        "id": 1,
        "name": "Bananas",
        "completed": false
    }
}
JSON;

        $item = new JsonShoppingItem(new ShoppingItem(
            1,
            "Bananas"
        ));

        $actual = json_encode(['item' => $item]);

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
