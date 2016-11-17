<?php

namespace Kartenmacherei\HttpFramework\Library\File;

class FileName
{
    /**
     * @var string
     */
    private $base;

    /**
     * @var string
     */
    private $extension;

    /**
     * @param string $base
     * @param string $extension
     */
    public function __construct($base, $extension)
    {
        $this->ensureIsString($base);
        $this->ensureIsString($extension);
        $this->base      = $base;
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function base()
    {
        return $this->base;
    }

    /**
     * @return string
     */
    public function extension()
    {
        return $this->extension;
    }

    /**
     * @param $value
     */
    private function ensureIsString($value)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException($value);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->base() . "." . $this->extension();
    }
}
