<?php

namespace Kartenmacherei\CQRSFramework\Routing\Routing\PostRoute;

use Kartenmacherei\CQRSFramework\Library\Exception\RoutingException;
use Kartenmacherei\CQRSFramework\Request\PostRequest;
use Kartenmacherei\CQRSFramework\Routing\Command\Command;

abstract class PostRoute
{
    /**
     * @var PostRoute
     */
    private $next;

    /**
     * @param PostRoute $route
     */
    public function setNext(PostRoute $route)
    {
        $this->next = $route;
    }

    /**
     * @param PostRequest $request
     * @return Command
     */
    final public function route(PostRequest $request)
    {
        if (!$this->matches($request)) {
            if ($this->next === null) {
                throw new RoutingException(
                    'No route matched the request'
                );
            }

            return $this->next->route($request);
        }

        return $this->buildCommand($request);
    }

    /**
     * @param PostRequest $request
     *
     * @return bool
     */
    abstract protected function matches(PostRequest $request);

    /**
     * @param PostRequest $request
     *
     * @return Command
     */
    abstract protected function buildCommand(PostRequest $request);
}
