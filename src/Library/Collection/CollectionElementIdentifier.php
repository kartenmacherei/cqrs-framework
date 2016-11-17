<?php

namespace Kartenmacherei\HttpFramework\Library\Collection;

interface CollectionElementIdentifier
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @param CollectionElementIdentifier $element
     * @return bool
     */
    public function equals(CollectionElementIdentifier $element);
}
