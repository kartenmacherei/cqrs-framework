<?php

namespace Kartenmacherei\CQRSFramework\Routing\GetRoute;

use Kartenmacherei\CQRSFramework\Library\Exception\RoutingException;
use Kartenmacherei\CQRSFramework\Request\GetRequest;
use Kartenmacherei\CQRSFramework\Routing\Query\Query;

abstract class GetRoute
{
    /**
     * @var GetRoute
     */
    private $next;

    /**
     * @param GetRoute $route
     */
    public function setNext(GetRoute $route)
    {
        $this->next = $route;
    }

    /**
     * @param GetRequest $request
     * @return Query
     */
    final public function route(GetRequest $request)
    {
        if (!$this->matches($request)) {
            if ($this->next === null) {
                throw new RoutingException(
                    'No route matched the request'
                );
            }

            return $this->next->route($request);
        }

        return $this->buildQuery($request);
    }

    /**
     * @param GetRequest $request
     * @return bool
     */
    abstract protected function matches(GetRequest $request);

    /**
     * @param GetRequest $request
     * @return Query
     */
    abstract protected function buildQuery(GetRequest $request);
}
