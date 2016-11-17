<?php

namespace Kartenmacherei\CQRSFramework\Routing;

use Kartenmacherei\CQRSFramework\Request\Request;
use Kartenmacherei\CQRSFramework\Response\Response;

interface RequestHandler
{
    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request) : Response;
}