<?php

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use VicFlora\Http\Controllers\API\ApiController;
use League\Fractal;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;


class ChangeController extends ApiController
{
    protected $changeModel;
    
    public function __construct() {
        parent::__construct();
        $this->changeModel = new \VicFlora\Models\ChangeModel();
    }
    
    /**
     * @SWG\Get(
     *     path="/changes",
     *     tags={"Changes"},
     *     summary="Lists Changes",
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/Change"
     *             )
     *         )
     *     )
     * )
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queryParams = array_diff_key($request->all(), array_flip(['page']));
        $pageSize = (isset($queryParams['pageSize'])) 
                ? $queryParams['pageSize'] : 20;
        $paginator = $this->changeModel->getChanges($queryParams, true, $pageSize);
        $paginator->appends($queryParams);
        
        $paginatorAdapter = new IlluminatePaginatorAdapter($paginator);
        $changes = $paginator->getCollection();
        $resource = new Fractal\Resource\Collection($changes, 
                new \VicFlora\Transformers\ChangeTransformer, 'changes');
        $resource->setPaginator($paginatorAdapter);
        $data = $this->fractal->createData($resource)->toArray();
        $data['meta']['queryParams'] = $queryParams;
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
