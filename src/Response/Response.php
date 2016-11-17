<?php
namespace Kartenmacherei\CQRSFramework\Response;

use Kartenmacherei\CQRSFramework\Library\SessionId;

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
