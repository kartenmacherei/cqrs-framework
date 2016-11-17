<?php

namespace Kartenmacherei\HttpFramework\Http;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use InvalidArgumentException;

/**
 *
 * @covers \Kartenmacherei\HttpFramework\Http\AbstractAuthenticator
 */
class AbstractAuthenticatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractAuthenticator | PHPUnit_Framework_MockObject_MockObject $abstractAuthenticatorMock
     */
    private $abstractAuthenticatorMock;

    /**
     * @var string
     */
    private $testUsername;

    /**
     * @var string
     */
    private $testPassword;

    protected function setup()
    {
        $this->abstractAuthenticatorMock = $this->getMockBuilder(AbstractAuthenticator::class)
                                                ->disableOriginalConstructor()
                                                ->setMethods(['checkCredentials'])
                                                ->getMockForAbstractClass();
        $this->testUsername              = 'TestUser';
        $this->testPassword              = 'TestPass';
    }

    public function testCannotCheckCredentials()
    {
        $this->abstractAuthenticatorMock
            ->method('checkCredentials')
            ->willThrowException(new InvalidArgumentException());

        $this->expectException(InvalidArgumentException::class);

        $this->abstractAuthenticatorMock->checkCredentials($this->testUsername, $this->testPassword);
    }
}
