<?php

namespace Marketismtech\ApiTester\Repositories;

use Marketismtech\ApiTester\Collections\RequestCollection;
use Marketismtech\ApiTester\Contracts\RequestRepositoryInterface;
use Marketismtech\ApiTester\Contracts\StorageInterface;
use Marketismtech\ApiTester\Entities\RequestEntity;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
/**
 * Class DefaultRequestRepository
 *
 * @package \Marketismtech\ApiTester
 */
class RequestRepository implements RequestRepositoryInterface
{
    /**
     * @type \Marketismtech\ApiTester\Collections\RequestCollection
     */
    protected $requests;

    /**
     * @type \Marketismtech\ApiTester\Contracts\StorageInterface
     */
    protected $storage;

    /**
     * RequestRepository constructor.
     *
     * @param \Marketismtech\ApiTester\Contracts\StorageInterface $storage
     * @internal param RequestCollection $requests
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
        $this->load();
    }

    /**
     * Get data from storage and load it into collection.
     * @return void
     */
    protected function load()
    {
        $this->requests = $this->storage->get();
    }

    /**
     * Replace existing collection with data loaded from storage.
     */
    protected function reload()
    {
        $this->requests = $this->requests->make($this->getDataFromStorage());
    }

    /**
     * Get all stored data storage.
     *
     * @return mixed
     */
    protected function getDataFromStorage()
    {
        return $this->storage->get();
    }

    /**
     * @param int $id
     *
     * @return RequestEntity
     */
    public function find($id)
    {
        return $this->requests->find($id);
    }

    /**
     * @param \Marketismtech\ApiTester\Entities\RequestEntity $request
     *
     * @return mixed
     */
    public function persist(RequestEntity $request)
    {
        $request->setId(Str::random(40));
        $this->requests->insert($request);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function exists($id)
    {
        return $this->requests->has($id);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->requests->values();
    }

    /**
     * @param string $id
     */
    public function remove($id)
    {
        $this->find($id)->markToDelete();
    }

    /**
     * @return void
     */
    public function flush()
    {
        $this->storage->put($this->requests);
    }
}
