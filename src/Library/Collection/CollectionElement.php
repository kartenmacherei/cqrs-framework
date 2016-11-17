<?php

namespace Kartenmacherei\CQRSFramework\Library\Collection;

interface CollectionElement
{
    /**
     * @return CollectionElementIdentifier
     */
    public function identifier();
}
