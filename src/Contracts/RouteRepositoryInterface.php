<?php

namespace Marketismtech\ApiTester\Contracts;

interface RouteRepositoryInterface
{
    /**
     * @param array $match
     * @param array $except
     *
     * @return mixed
     */
    public function get($match = [], $except = []);
}
