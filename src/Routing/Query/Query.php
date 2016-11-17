<?php
namespace Kartenmacherei\CQRSFramework\Routing\Query;

use Kartenmacherei\CQRSFramework\Response\Response;

interface Query
{
    /**
     * @return Response
     */
    public function execute();
}
