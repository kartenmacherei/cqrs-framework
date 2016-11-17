<?php
namespace Kartenmacherei\HttpFramework\Routing\Command;

use Kartenmacherei\HttpFramework\Response\Response;

interface Command
{
    /**
     * @return Response
     */
    public function execute();
}
