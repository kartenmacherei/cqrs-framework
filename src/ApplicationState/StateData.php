<?php

namespace Kartenmacherei\CQRSFramework\ApplicationState;

use Kartenmacherei\CQRSFramework\Library\SessionId;

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
