<?php
declare(strict_types=1);

namespace Lindyhopchris\ShoppingList\Persistance\Json;

use InvalidArgumentException;
use JsonException;
use RuntimeException;

class JsonFileHandler
{
    /**
     * @var string
     */
    private string $directory;

    /**
     * @param string $directory
     */
    public function __construct(string $directory)
    {
        if (empty($directory) || !is_dir($directory)) {
            throw new InvalidArgumentException('Expecting a valid directory for storing JSON.');
        }

        $this->directory = $directory;
    }

    /**
     * Does the JSON file exist?
     *
     * @param string $filename
     * @return bool
     */
    public function exists(string $filename): bool
    {
        return file_exists($this->pathTo($filename));
    }

    /**
     * Read a JSON file and decode the contents.
     *
     * @param string $filename
     * @return string
     */
    public function read(string $filename): string
    {
        $path = $this->pathTo($filename);

        if (!file_exists($path)) {
            throw new RuntimeException('Invalid filename: ' . $filename);
        }

        $content = file_get_contents($path);

        if (false === $content) {
            throw new RuntimeException('Error reading file: ' . $filename);
        }

        return $content;
    }

    /**
     * Read a JSON file and decode its contents to an array.
     *
     * @param string $filename
     * @return array
     */
    public function decode(string $filename): array
    {
        $json = $this->read($filename);

        try {
            $values = json_decode(
                json: $json,
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            );
        } catch (JsonException $ex) {
            throw new RuntimeException('Failed to decode JSON from file: ' . $filename, 0, $ex);
        }

        if (!is_array($values)) {
            throw new RuntimeException("JSON in file {$filename} does not decode to an array.");
        }

        return $values;
    }

    /**
     * Write a JSON file using the provided key.
     *
     * @param string $filename
     * @param mixed $jsonable
     * @return void
     */
    public function write(string $filename, mixed $jsonable): void
    {
        try {
            $content = json_encode($jsonable, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        } catch (JsonException $ex) {
            throw new RuntimeException('Failed to encode JSON value.', 0, $ex);
        }

        $result = file_put_contents($this->pathTo($filename), $content);

        if (false === $result) {
            throw new RuntimeException('Failed to write JSON file.');
        }
    }

    /**
     * Remove the file from storage.
     *
     * @param string $filename
     * @return void
     */
    public function unlink(string $filename): void
    {
        // Given the path to the file
        $path = $this->pathTo($filename);
        // If the list of that filename exists then
        if ($this->exists($filename)) {
            // Delete the list
            unlink($filename);
        } else {
            throw new InvalidArgumentException('Expecting a valid list name to delete the list.');
        }
    }

    /**
     * Get the full path to a filename.
     *
     * @param string $filename
     * @return string
     */
    private function pathTo(string $filename): string
    {
        return $this->directory . '/' . $filename;
    }
}
