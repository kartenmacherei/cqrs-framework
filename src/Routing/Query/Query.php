<?php
namespace Kartenmacherei\HttpFramework\Routing\Query;

use Kartenmacherei\HttpFramework\Response\Response;

interface Query
{
    /**
     * @return Response
     */
    public function execute();
}
