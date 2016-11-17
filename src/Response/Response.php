<?php
namespace Kartenmacherei\HttpFramework\Response;

use Kartenmacherei\HttpFramework\Library\SessionId;

interface Response
{
    public function send();

    /**
     * @param SessionId $sessionId
     */
    public function setSessionId(SessionId $sessionId);

    /**
     * @return SessionId
     */
    public function getSessionId();
}
