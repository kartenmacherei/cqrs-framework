<?php

namespace Kartenmacherei\CQRSFramework\Library\Collection;

use InvalidArgumentException;

abstract class AbstractIdentifier implements CollectionElementIdentifier
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @param string $identifier
     */
    public function __construct($identifier)
    {
        $this->ensureIsString($identifier);

        $this->identifier = $identifier;
    }

    /**
     * @param $identifier
     * @throws InvalidArgumentException
     */
    private function ensureIsString($identifier)
    {
        if (!is_string($identifier)) {
            throw new InvalidArgumentException('Identifier must be a string.');
        }
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->asString();
    }

    /** @param CollectionElementIdentifier $element
     * @return bool
     */
    public function equals(CollectionElementIdentifier $element)
    {
        if ((string) $this != (string) $element) {
            return false;
        }

        return true;
    }
}
