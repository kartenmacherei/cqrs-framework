<?php

namespace Kartenmacherei\HttpFramework\Http;

use PHPUnit_Framework_TestCase;

/**
 * @covers \Kartenmacherei\HttpFramework\Http\Ldap
 */
class LdapTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Ldap
     */
    private $ldap;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $userDomain;

    /**
     * @var string
     */
    private $distinguishedName;

    /**
     * @var bool
     */
    private $tls;

    /**
     * @var array
     */
    private $options;

    protected function setup()
    {
        $this->host = "ldap://dceds01.insightglobal.net";
        $this->port = 389;
        $this->userDomain = "DC=insightglobal,DC=net";
        $this->distinguishedName = "@insightglobal.net";
        $this->tls = false;
        $this->options = [
            'LDAP_OPT_PROTOCOL_VERSION' => 3,
            'LDAP_OPT_REFERRALS' => 0,
            'LDAP_OPT_SIZELIMIT' => 1000
        ];

        $this->ldap = new Ldap(
            $this->host,
            $this->port,
            $this->distinguishedName,
            $this->userDomain,
            $this->tls,
            $this->options
        );
    }

    public function testCanGetHost()
    {
        $this->assertEquals($this->host, $this->ldap->host());
    }

    public function testCanGetPort()
    {
        $this->assertEquals($this->port, $this->ldap->port());
    }
}
