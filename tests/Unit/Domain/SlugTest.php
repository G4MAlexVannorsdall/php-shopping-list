<?php
declare(strict_types=1);

namespace Tests\Unit\Domain;

use Lindyhopchris\ShoppingList\Domain\Slug;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{
    /**
     * @return array
     */
    public function validProvider(): array
    {
        return [
            ['mylist'],
            ['my-list'],
        ];
    }

    /**
     * @param string $value
     * @return void
     * @dataProvider validProvider
     */
    public function testConstructValid(string $value): void
    {
        $slug = new Slug($value);

        $this->assertSame($value, (string) $slug);
    }

    /**
     * @return array
     */
    public function invalidProvider(): array
    {
        return [
            ['MY-TEST'],
            ['my'],
            [true],
            [1],
            [[]],
            [(object) ['foo' => 'bar']],
        ];
    }

    /**
     * @param mixed $value
     * @return void
     * @dataProvider invalidProvider
     */
    public function testConstructInvalid(mixed $value): void
    {
        if (is_string($value)) {
            $this->expectException(\UnexpectedValueException::class);
            $this->expectExceptionMessage('Expecting a valid slug.');
        } else {
            $this->expectException(\TypeError::class);
        }

        new Slug($value);
    }

    /**
     * @param string $value
     * @return void
     * @dataProvider validProvider
     */
    public function testIsValid(string $value): void
    {
        $this->assertTrue(Slug::isValid($value));
    }

    /**
     * @param mixed $value
     * @return void
     * @dataProvider invalidProvider
     */
    public function testIsInvalid(mixed $value): void
    {
        $this->assertFalse(Slug::isValid($value));
    }

    public function testJsonSerialize(): void
    {
        $expected = '{"slug": "my-groceries"}';
        $json = json_encode(['slug' => new Slug('my-groceries')]);

        $this->assertJsonStringEqualsJsonString($expected, $json);
    }
}
