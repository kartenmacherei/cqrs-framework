<?php

namespace Kartenmacherei\HttpFramework\Http;

use PHPUnit_Framework_TestCase;

/**
 * @uses   \Kartenmacherei\HttpFramework\Http\Ldap
 * @covers \Kartenmacherei\HttpFramework\Http\ActiveDirectoryAuthenticator
 */
class ActiveDirectoryAuthenticatorTest extends PHPUnit_Framework_TestCase
{
    /** @var Ldap */
    private $ldap;

    /** @var ActiveDirectoryAuthenticator */
    private $ActiveDirectoryAuthenticator;

    /** @var string */
    private $testUserName;

    /** @var string */
    private $testPassword;

    /** @var string */
    private $testLockedUserName;

    /** @var string */
    private $testLockedPassword;

    /** @var string */
    private $testEmptyUsername;

    /** @var string */
    private $testEmptyPassword;

    protected function setup()
    {
        // User Setup
        $this->testUserName       = 'testy.test@insightglobal.net';
        $this->testPassword       = "Abc_1234";
        $this->testLockedUserName = 'sdfsd';
        $this->testLockedPassword = 'sdfsd';
        $this->testEmptyUsername  = '';
        $this->testEmptyPassword  = '';
    }

    private function setupTLS()
    {
        $this->ldap                         = new Ldap(
            "ldap://dceds01.insightglobal.net",
            389,
            "DC=insightglobal,DC=net",
            "@insightglobal.net",
            true,
            [
                'LDAP_OPT_PROTOCOL_VERSION' => 3,
                'LDAP_OPT_REFERRALS'        => 0,
                'LDAP_OPT_SIZELIMIT'        => 1000
            ]
        );
        $this->ActiveDirectoryAuthenticator = new ActiveDirectoryAuthenticator($this->ldap);
    }

    public function tearDown()
    {
        unset($this->ActiveDirectoryAuthenticator);
        unset($this->ldap);
    }

    public function testCannotSuccessfullyAuthenticateEmptyUserInfoWithTLS()
    {   $this->markTestSkipped('fuck this');
        $this->setupTLS();

        $this->assertFalse(
            $this->ActiveDirectoryAuthenticator->checkCredentials(
                $this->testEmptyUsername,
                $this->testEmptyPassword
            )
        );
    }

    public function testCanSuccessfullyAuthenticateUserWithTLS()
    {
        $this->markTestSkipped('we need jesus');
        $this->setupTLS();

        $this->assertTrue(
            $this->ActiveDirectoryAuthenticator->checkCredentials($this->testUserName, $this->testPassword)
        );
    }

    public function testCannotSuccessfullyAuthenticateInvalidUserWithTLS()
    {
        $this->markTestSkipped('jesus take the wheel');
        $this->setupTLS();

        $this->assertFalse(
            $this->ActiveDirectoryAuthenticator->checkCredentials(
                $this->testLockedUserName,
                $this->testLockedPassword
            )
        );
        $this->assertEquals('Invalid credentials', $this->ActiveDirectoryAuthenticator->lastError());
    }
}
