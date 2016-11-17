<?php

namespace Kartenmacherei\HttpFramework\Library\Collection;

abstract class AbstractCollection implements Collection
{
    /**
     * @var array
     */
    protected $elements = [];

    public function current()
    {
        return current($this->elements);
    }

    public function next()
    {
        next($this->elements);
    }

    /**
     * @return array
     */
    public function retrieveAll()
    {
        return $this->elements;
    }

    /**
     * @return string
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $key = key($this->elements);

        if ($key !== null && $key !== false) {
            return true;
        }

        return false;
    }

    public function rewind()
    {
        reset($this->elements);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * @param AbstractIdentifier $identifier
     * @return bool
     */
    public function hasElementByIdentifier(AbstractIdentifier $identifier)
    {
        return isset($this->elements[$identifier->asString()]);
    }

    /**
     * @param AbstractIdentifier $identifier
     * @return mixed
     */
    public function getElementByIdentifier(AbstractIdentifier $identifier)
    {
        return $this->elements[$identifier->asString()];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->elements;
    }
}
