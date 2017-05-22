<?php

namespace Kartenmacherei\CQRSFramework\ApplicationState;

use Kartenmacherei\CQRSFramework\Library\SessionId;

class StateData
{
    /**
     * @var SessionId
     */
    protected $sessionId;

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
    public function sessionId(): SessionId
    {
        return $this->sessionId;
    }
}
