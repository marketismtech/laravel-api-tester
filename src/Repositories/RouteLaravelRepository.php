<?php

namespace Marketismtech\ApiTester\Repositories;

use Marketismtech\ApiTester\Collections\RouteCollection;
use Marketismtech\ApiTester\Contracts\RouteRepositoryInterface;
use Marketismtech\ApiTester\Entities\RouteInfo;
use Illuminate\Routing\Router;

class RouteLaravelRepository implements RouteRepositoryInterface
{
    /**
     * @type \Marketismtech\ApiTester\Collections\RouteCollection
     */
    protected $routes;

    public function __construct(RouteCollection $collection, Router $router)
    {
        $this->routes = $collection;

        foreach ($router->getRoutes() as $route) {
            $routeInfo = (new RouteInfo($route, ['router' => 'Laravel']))->toArray();
            $this->routes->push($routeInfo);
        }
    }

    /**
     * @param array $match
     * @param array $except
     *
     * @return \Marketismtech\ApiTester\Collections\RouteCollection
     */
    public function get($match = [], $except = [])
    {
        return $this->routes->filterMatch($match)
            ->filterExcept($except)
            ->values();
    }
}
