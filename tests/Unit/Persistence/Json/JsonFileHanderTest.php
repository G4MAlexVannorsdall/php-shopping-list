<?php
declare(strict_types=1);

namespace Tests\Unit\Persistence\Json;

use Lindyhopchris\ShoppingList\Persistance\Json\JsonFileHandler;
use PHPUnit\Framework\TestCase;

class JsonFileHanderTest extends TestCase
{
    private const DIRECTORY = __DIR__ . '/../../../storage';
    private const TEST_FILE = self::DIRECTORY . '/test.json';

    /**
     * @var JsonFileHandler
     */
    private JsonFileHandler $handler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new JsonFileHandler(self::DIRECTORY);
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        if (file_exists(self::TEST_FILE)) {
            unlink(self::TEST_FILE);
        }
    }

    public function testDecode(): void
    {
        $expected = ['data' => ['foo' => 'bar']];

        file_put_contents(self::TEST_FILE, json_encode($expected));

        $this->assertSame($expected, $this->handler->decode('test.json'));
    }

    public function testWrite(): void
    {
        $values = ['data' => ['baz' => 'bat']];
        $expected = json_encode($values);

        $didExist = $this->handler->exists('test.json');
        $this->handler->write('test.json', $values);
        $nowExists = $this->handler->exists('test.json');

        $this->assertFalse($didExist);
        $this->assertFileExists(self::TEST_FILE);
        $this->assertTrue($nowExists);

        $actual = file_get_contents(self::TEST_FILE);

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    public function testUnlink(): void
    {
        // Arrange: Given a file exists
        file_put_contents(self::TEST_FILE, '');
        // Act: When we delete the file
        $this->handler->unlink('test.json');
        // Assert: The file has been deleted
        $this->assertFileDoesNotExist(self::TEST_FILE);

    }
}
