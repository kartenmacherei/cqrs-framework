<?php

namespace Kartenmacherei\HttpFramework\Library\Parameter;


use Kartenmacherei\HttpFramework\Library\Collection\AbstractCollection;

class ParameterCollection extends AbstractCollection
{
    /**
     * @param Parameter $parameter
     */
    public function add(Parameter $parameter)
    {
        $this->elements[$parameter->identifier()->asString()] = $parameter;
    }

    /**
     * @param array $parameters
     *
     * @return ParameterCollection
     */
    public static function fromArray(array $parameters)
    {
        $collection = new self;

        foreach ($parameters as $name => $value) {
            $collection->add(
                new Parameter(
                    new ParameterIdentifier($name),
                    $value
                )
            );
        }
        return $collection;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasParameter($name)
    {
        return $this->hasElementByIdentifier(new ParameterIdentifier($name));
    }

    /**
     * @param string $name
     * @return Parameter
     */
    public function value($name)
    {
        return $this->getElementByIdentifier(new ParameterIdentifier($name));
    }

    /**
     * @return Parameter[]
     */
    public function parameters()
    {
        return $this->elements;
    }
}
