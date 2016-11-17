<?php
namespace Kartenmacherei\CQRSFramework\Routing\GetRoute;

use Kartenmacherei\CQRSFramework\Library\Exception\RoutingException;
use Kartenmacherei\CQRSFramework\Request\GetRequest;
use Kartenmacherei\CQRSFramework\Routing\Query\Query;

class GetRouteChain
{
    /**
     * @var GetRoute
     */
    private $first;

    /**
     * @var GetRoute
     */
    private $last;

    /**
     * @param GetRequest $request
     * @return Query
     * @throws RoutingException
     */
    public function route(GetRequest $request) : Query
    {
        $query = $this->first->route($request);

        return $query;
    }

    /**
     * @param GetRoute $route
     */
    public function add(GetRoute $route)
    {
        if ($this->first === null) {
            $this->first = $route;
        }

        if ($this->last !== null) {
            $this->last->setNext($route);
        }

        $this->last = $route;
    }
}
