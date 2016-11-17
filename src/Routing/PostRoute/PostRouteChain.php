<?php
namespace Kartenmacherei\CQRSFramework\Routing\PostRoute;

use Kartenmacherei\CQRSFramework\Library\Exception\RoutingException;
use Kartenmacherei\CQRSFramework\Request\PostRequest;
use Kartenmacherei\CQRSFramework\Routing\Command\Command;
use Kartenmacherei\CQRSFramework\Routing\Routing\PostRoute\PostRoute;

class PostRouteChain
{
    /**
     * @var PostRoute
     */
    private $first;

    /**
     * @var PostRoute
     */
    private $last;

    /**
     * @param PostRequest $request
     * @return Command
     * @throws RoutingException
     */
    public function route(PostRequest $request) : Command
    {
        $command = $this->first->route($request);

        return $command;
    }

    /**
     * @param PostRoute $route
     */
    public function add(PostRoute $route)
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
