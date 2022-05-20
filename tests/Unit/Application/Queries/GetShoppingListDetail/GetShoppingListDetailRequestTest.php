<?php

namespace Tests\Unit\Application\Queries\GetShoppingListDetail;

use Lindyhopchris\ShoppingList\Application\Queries\GetShoppingListDetail\GetShoppingListDetailRequest;
use PHPUnit\Framework\TestCase;

class GetShoppingListDetailRequestTest extends TestCase
{
    public function testGivenSlugAndFilterValue(): void
    {
        $request = new GetShoppingListDetailRequest('supplies', 'all');

        $this->assertEquals('supplies', $request->getSlug());
        $this->assertEquals('all', $request->getFilterValue());
    }
}
