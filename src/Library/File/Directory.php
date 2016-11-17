<?php

namespace Kartenmacherei\CQRSFramework\Library\File;

use InvalidArgumentException;
use Kartenmacherei\CQRSFramework\Library\Exception\InvalidPathException;

class Directory
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->ensureIsString($directory);
        $directory = $this->terminatePathWithSlash($directory);
        $this->ensureDirectoryExists($directory);

        $this->directory = $directory;
    }

    /**
     * @param $directory
     * @throws InvalidArgumentException
     */
    private function ensureIsString($directory)
    {
        if (!is_string($directory)) {
            throw new InvalidArgumentException('This directory is not a string');
        }
    }

    /**
     * @param $directory
     * @return string
     */
    private function terminatePathWithSlash($directory)
    {
        if (!(substr($directory, -1) == '/')) {
            return $directory . '/';
        }

        return $directory;
    }

    /**
     * @param $directory
     */
    private function ensureDirectoryExists($directory)
    {
        if (!is_dir($directory)) {
            throw new InvalidPathException(sprintf("Directory '%s' does not exist.", $directory));
        }
    }

    /**
     * @param FileName $fileName
     * @return File
     */
    public function file(FileName $fileName)
    {
        return new File($this, $fileName);
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->directory;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->directory;
    }
}
