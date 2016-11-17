<?php
namespace Kartenmacherei\CQRSFramework\Routing\Command;

use Kartenmacherei\CQRSFramework\Response\Response;

interface Command
{
    /**
     * @return Response
     */
    public function execute();
}
