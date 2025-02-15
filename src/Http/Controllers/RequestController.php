<?php

namespace Marketismtech\ApiTester\Http\Controllers;

use Marketismtech\ApiTester\Contracts\RequestRepositoryInterface;
use Marketismtech\ApiTester\Entities\RequestEntity;
use Marketismtech\ApiTester\Http\Requests\StoreRequest;
use Marketismtech\ApiTester\Http\Requests\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class RequestController
 *
 * @package \Marketismtech\ApiTester\Http\Controllers
 */
class RequestController extends Controller
{
    /**
     * @type \Marketismtech\ApiTester\Contracts\RequestRepositoryInterface
     */
    protected $repository;

    /**
     * RequestController constructor.
     *
     * @param \Marketismtech\ApiTester\Contracts\RequestRepositoryInterface $repository
     */
    public function __construct(RequestRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = $this->repository->all();

        return response(compact('data'), 200);
    }

    /**
     *
     * @param \Marketismtech\ApiTester\Http\Requests\StoreRequest $storeRequest
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $storeRequest)
    {
        $request = new RequestEntity($storeRequest->all());

        $this->repository->persist($request);

        $this->repository->flush();

        // TODO Serializable?
        return response(['data' => $request->toArray()], 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        if (! $this->repository->exists($id)) {
            return response(null, 404);
        }

        $this->repository->remove($id);

        $this->repository->flush();

        return response(null, 204);
    }

    /**
     * @param \Marketismtech\ApiTester\Http\Requests\UpdateRequest $request
     * @param  string                                      $request
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     *
     */
    public function update(UpdateRequest $request)
    {
        $requestEntity = $this->repository->find($request->id);

        // TODO What's happening in here?
        if (!$requestEntity instanceof RequestEntity) {
            return response(404);
        }

        $requestEntity->update($request->all());
        $this->repository->flush();

        return response(['data' => $requestEntity->toArray()], 200);
    }
}
