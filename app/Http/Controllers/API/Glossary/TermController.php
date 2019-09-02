<?php

namespace VicFlora\Http\Controllers\API\Glossary;

use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal;
use VicFlora\Http\Controllers\API\ApiController;

class TermController extends ApiController
{
    protected $termModel;
    
    public function __construct() {
        parent::__construct();
        $this->termModel = new \VicFlora\Models\Glossary\TermModel();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @SWG\Get(
     *     path="/glossary/terms",
     *     tags={"Glossary"},
     *     summary="Lists glossary Terms",
     *     @SWG\Parameter(
     *         in="query",
     *         name="filter[term]",
     *         type="string",
     *         description="Term"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="include",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"relationships", "creator", "modifiedBy"}
     *         ),
     *         collectionFormat="csv",
     *         description="Extra linked resources to include in the result; multiple resources can be included, separated by a comma."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="paginate",
     *       type="boolean",
     *       default=true,
     *       description="Whether or not to paginate the result"
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="pageSize",
     *       type="integer",
     *       format="int32",
     *       description="The number of results to return."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="page",
     *       type="integer",
     *       format="int32",
     *       description="The page of query results to return."
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/GlossaryTerm"
     *             )
     *         )
     *     )
     * )
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queryParams = array_diff_key($request->all(), array_flip(['page']));
        $pageSize = (isset($queryParams['pageSize'])) 
                ? $queryParams['pageSize'] : 20;
        
        $paginator = $this->termModel->getTerms($queryParams, true, $pageSize);
        $paginator->appends($queryParams);
        $paginatorAdapter = new IlluminatePaginatorAdapter($paginator);
        $terms = $paginator->getCollection();
        $transformer = new \VicFlora\Transformers\GlossaryTermTransformer();
        $transformer->setDefaultIncludes(['relationships']);
        $resource = new Fractal\Resource\Collection($terms, $transformer, 'glossary/terms');
        $resource->setPaginator($paginatorAdapter);
        $data = $this->fractal->createData($resource)->toArray();
        $data['meta']['queryParams'] = $queryParams;
        return $this->responseWithRedirectMessage($data);
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
     * @SWG\Get(
     *     path="/glossary/terms/{term}",
     *     tags={"Glossary"},
     *     summary="Gets a glossary Term",
     *     @SWG\Parameter(
     *         in="path",
     *         name="term",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Term"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="include",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"relationships", "creator", "modifiedBy"}
     *         ),
     *         collectionFormat="csv",
     *         description="Extra linked resources to include in the result; multiple resources can be included, separated by a comma."
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/GlossaryTerm"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     )
     * )
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_uuid($id)) {
            return $this->errorResponse(400, 'Not a valid UUID');
        }
        $term = $this->termModel->getTerm($id);
        if (!$term) {
            return $this->errorResponse(404);
        }
        $resource = new Fractal\Resource\Item($term, 
                new \VicFlora\Transformers\GlossaryTermTransformer, 'terms');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
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
