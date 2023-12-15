<?php

namespace Marketismtech\ApiTester\Contracts;

use Marketismtech\ApiTester\Collections\RequestCollection;

/**
 * Class StorageInterface
 *
 * @package \Marketismtech\ApiTester\Contracts
 */
interface StorageInterface
{

    /**
     * Get data from resource.
     *
     * @return RequestCollection
     */
    public function get();

    /**
     * Put data to resource.
     *
     * @param $data RequestCollection
     * @return void
     */
    public function put(RequestCollection $data);
}
