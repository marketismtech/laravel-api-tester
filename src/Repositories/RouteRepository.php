<?php

namespace Marketismtech\ApiTester\Repositories;

use Marketismtech\ApiTester\Collections\RouteCollection;
use Marketismtech\ApiTester\Contracts\RouteRepositoryInterface;

/**
 * Class RouteRepository
 *
 * @package \Marketismtech\ApiTester\Repositories
 */
class RouteRepository implements RouteRepositoryInterface
{
    /**
     * @type \Marketismtech\ApiTester\Contracts\RouteRepositoryInterface[]
     */
    protected $repositories;

    /**
     * @type \Marketismtech\ApiTester\Collections\RouteCollection
     */
    protected $routes;

    public function __construct(RouteCollection $routes, $repositories)
    {
        $this->routes = $routes;
        $this->repositories = $repositories;
    }

    /**
     * @param array $match
     * @param array $except
     *
     * @return mixed
     */
    public function get($match = [], $except = [])
    {
        foreach ($this->repositories as $repository) {

            foreach ($repository->get($match, $except) as $route) {
                $this->routes->push($route);
            }
        }

        return $this->routes;
    }
}
