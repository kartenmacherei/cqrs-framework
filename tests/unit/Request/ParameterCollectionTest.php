<?php
namespace Kartenmacherei\CQRSFramework\Http;

/**
 * @uses   \Kartenmacherei\CQRSFramework\Http\Parameter
 * @uses   \Kartenmacherei\CQRSFramework\Library\Collection
 * @uses   \Kartenmacherei\CQRSFramework\Library\AbstractIdentifier
 *
 * @covers \Kartenmacherei\CQRSFramework\Http\ParameterCollection
 */
class ParameterCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ParameterCollection
     */
    protected $parameterCollection;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->parameterCollection = new ParameterCollection;
    }

    public function testCanBeCreatedFromEmptyArray()
    {
        $parameterCollection = ParameterCollection::fromArray([]);
        $this->assertInstanceOf(ParameterCollection::class, $parameterCollection);
    }

    public function testCanBePopulatedFromArray()
    {
        $parameterCollection = ParameterCollection::fromArray(
            [
                'quest' => 'To seek the holy grail.',
                'avgAirspeedVelocityOfUnladenSwallow' => 'Wait, what?',
                'Ahhhhh' => 'splash'
            ]
        );
        $this->assertInstanceOf(ParameterCollection::class, $parameterCollection);
    }

    public function testCanBePopulatedWithObjectsAndArraysFromArray()
    {
        $parameterCollection = ParameterCollection::fromArray(
            [
                'drinks' => ['red bull' => 'wings', 'coca-cola' => 'smile'],
                'cereal' => serialize(new \stdClass([])),
                'object' => new \stdClass()
            ]
        );
        $this->assertInstanceOf(ParameterCollection::class, $parameterCollection);
    }
}
