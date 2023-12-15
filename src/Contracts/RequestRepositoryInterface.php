<?php

namespace Marketismtech\ApiTester\Contracts;

use Marketismtech\ApiTester\Entities\RequestEntity;

interface RequestRepositoryInterface
{
    /**
     * @param $id
     *
     * @return \Marketismtech\ApiTester\Entities\RequestEntity
     */
    public function find($id);

    /**
     * @param \Marketismtech\ApiTester\Entities\RequestEntity $request
     *
     * @return void
     */
    public function persist(RequestEntity $request);

    /**
     * @param $id
     *
     * @return bool
     */
    public function exists($id);

    /**
     * @return \Marketismtech\ApiTester\Collections\RequestCollection|\Marketismtech\ApiTester\Entities\RequestEntity[]
     */
    public function all();

    /**
     * @return void
     */
    public function flush();

    /**
     * @param string $request
     */
    public function remove($request);

}
