<?php

namespace Kartenmacherei\HttpFramework\ApplicationState;

use Kartenmacherei\HttpFramework\Library\SessionId;

class StateData
{
    /**
     * @var SessionId
     */
    private $sessionId;

    /**
     * @var bool
     */
    private $loggedIn = false;

    /**
     * @param SessionId $sessionId
     */
    public function __construct(SessionId $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return SessionId
     */
    public function sessionId()
    {
        return $this->sessionId;
    }

    public function setAsLoggedIn()
    {
        $this->sessionId->regenerate();

        $this->loggedIn = true;
    }

    public function setAsLoggedOut()
    {
        $this->sessionId->regenerate();

        $this->loggedIn = false;
    }

    public function isLoggedIn()
    {
        return $this->loggedIn;
    }
}
