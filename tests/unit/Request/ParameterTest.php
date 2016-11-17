<?php
namespace Kartenmacherei\CQRSFramework\Http;

/**
 * @covers \Kartenmacherei\CQRSFramework\Http\Parameter
 *
 * @uses   Kartenmacherei\CQRSFramework\Library\AbstractIdentifier
 */
class ParameterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Parameter
     */
    protected $parameter;

    /**
     * @var ParameterIdentifier | \PHPUnit_Framework_MockObject_MockObject
     */
    private $parameterIdMock;

    /**
     * @var string
     */
    private $parameterValue;

    protected function setUp()
    {
        $this->parameterValue = 'value';

        $this->parameterIdMock = $this->getMockBuilder(ParameterIdentifier::class)
                                      ->disableOriginalConstructor()
                                      ->getMock();

        $this->parameter = new Parameter($this->parameterIdMock, $this->parameterValue);
    }

    public function testIdentifierCanBeRetrieved()
    {
        $this->assertEquals($this->parameterIdMock, $this->parameter->getIdentifier());
    }

    public function testGetValue()
    {
        $this->assertEquals($this->parameterValue, $this->parameter->getValue());
    }

    public function testCanBeConvertedToString()
    {
        $expectedString = $this->parameterValue;

        $this->assertEquals($expectedString, (string) $this->parameter);
    }
}
