<?php

namespace Kartenmacherei\HttpFramework\Response;

use Kartenmacherei\HttpFramework\Library\SessionId;

abstract class AbstractResponse implements Response
{
    /**
     * @var SessionId
     */
    private $sessionId;

    /**
     * @return SessionId
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param SessionId $sessionId
     */
    public function setSessionId(SessionId $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function send()
    {
        if (isset($this->sessionId)) {
            setcookie($this->sessionId->getCookieName(), $this->sessionId->asString());
        }
        $this->doSend();
    }

    abstract protected function doSend();
}
