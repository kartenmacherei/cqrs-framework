<?php
namespace Kartenmacherei\HttpFramework\Library\Parameter;

use Kartenmacherei\HttpFramework\Library\Collection\CollectionElement;

class Parameter implements CollectionElement
{
    /**
     * @var ParameterIdentifier
     */
    private $key;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param ParameterIdentifier $key
     * @param $value
     */
    public function __construct(ParameterIdentifier $key, $value)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * @return ParameterIdentifier
     */
    public function identifier()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value();
    }
}
