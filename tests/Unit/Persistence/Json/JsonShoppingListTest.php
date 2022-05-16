<?php
declare(strict_types=1);

namespace Tests\Unit\Persistence\Json;

use Lindyhopchris\ShoppingList\Domain\ShoppingItem;
use Lindyhopchris\ShoppingList\Domain\ShoppingItemStack;
use Lindyhopchris\ShoppingList\Domain\ShoppingList;
use Lindyhopchris\ShoppingList\Domain\ValueObjects\Slug;
use Lindyhopchris\ShoppingList\Persistance\Json\JsonShoppingList;
use PHPUnit\Framework\TestCase;

class JsonShoppingListTest extends TestCase
{
    public function test(): void
    {
        $expected = <<<JSON
{
    "list": {
        "slug": "my-list",
        "name": "My List",
        "items": [
            {
                "id": 1,
                "name": "Bananas",
                "completed": false
            },
            {
                "id": 2,
                "name": "Apples",
                "completed": true
            }
        ]
    }
}
JSON;

        $items = new ShoppingItemStack(
            new ShoppingItem(1, 'Bananas'),
            new ShoppingItem(2, 'Apples', true),
        );

        $list = new JsonShoppingList(new ShoppingList(
            new Slug('my-list'),
            'My List',
            $items,
        ));

        $actual = json_encode(['list' => $list]);

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
