<?php

namespace Marketismtech\ApiTester\Repositories;

use Marketismtech\ApiTester\Collections\RouteCollection;
use Marketismtech\ApiTester\Contracts\RouteRepositoryInterface;
use Marketismtech\ApiTester\Entities\RouteInfo;
use Dingo\Api\Routing\Router;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class RouteDingoRepository
 *
 * @package \Marketismtech\ApiTester\Repositories
 */
class RouteDingoRepository implements RouteRepositoryInterface
{
    /**
     * @type \Marketismtech\ApiTester\Collections\RouteCollection
     */
    protected $routes;

    public function __construct(RouteCollection $collection, Router $router, Config $config)
    {
        $this->routes = $collection;
        $standardsTree = $config['api.standardsTree'];
        $subtype = $config['api.subtype'];
        $defaultFormat = $config['api.defaultFormat'];

        foreach ($router->getAdapterRoutes() as $versionName => $versionGroup) {
            foreach ($versionGroup as $route) {
                $routeInfo = (new RouteInfo($route, [
                    'router' => 'Dingo',
                    'version' => $versionName,
                    'headers' => [
                        [
                            'key' => 'Accept',
                            'value' => "application/{$standardsTree}.{$subtype}.{$versionName}+{$defaultFormat}"
                        ]
                    ]
                ]))->toArray();
                $this->routes->push($routeInfo);
            }
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
