<?php

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal;
use VicFlora\Http\Controllers\API\ApiController;
use VicFlora\Models\ReferenceModel;
use Illuminate\Support\Facades\DB;

class ReferenceController extends ApiController
{
    protected $referenceModel;
    
    public function __construct() {
        parent::__construct();
        $this->referenceModel = new ReferenceModel();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @SWG\Get(
     *     path="/references/{reference}",
     *     tags={"References"},
     *     summary="Gets a Reference record",
     *     @SWG\Parameter(
     *         in="path",
     *         name="reference",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Reference"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/Reference"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     )
     * )
     * 
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reference = $this->referenceModel->getReference($id);
        if (!$reference) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $transformer = new \VicFlora\Transformers\ReferenceTransformer();
        $resource = new Fractal\Resource\Item($reference, $transformer, 
                'references');
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
    
    /**
     * @SWG\Get(
     *     path="/references/{reference}/publishedIn",
     *     tags={"References"},
     *     summary="Gets the Reference a Reference was published in",
     *     @SWG\Parameter(
     *         in="path",
     *         name="reference",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Reference"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/Reference"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     )
     * )
     * 
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function showPublishedIn($id)
    {
        $reference = $this->referenceModel->getReference($id);
        if (!$reference) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        if ($reference->published_in) {
            $publishedIn = $this->referenceModel->getReference($reference->published_in);
            $transformer = new \VicFlora\Transformers\ReferenceTransformer();
            $resource = new Fractal\Resource\Item($publishedIn, $transformer, 
                    'references');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/references/{reference}/creator",
     *     tags={"References"},
     *     summary="Gets creator of a Reference",
     *     @SWG\Parameter(
     *         in="path",
     *         name="agent",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Reference"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/Agent"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     )
     * )
     * 
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function showCreator($id)
    {
        $ref = $this->referenceModel->getReference($id);
        if (!$ref) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($ref->creator);
        $transformer = new \VicFlora\Transformers\AgentTransformer();
        $resource = new Fractal\Resource\Item($agent, $transformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }

    /**
     * @SWG\Get(
     *     path="/references/{reference}/modifiedBy",
     *     tags={"References"},
     *     summary="Gets Agent who last modified a Reference",
     *     @SWG\Parameter(
     *         in="path",
     *         name="agent",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Reference"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/Agent"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     )
     * )
     * 
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function showModifiedBy($id)
    {
        $ref = $this->referenceModel->getReference($id);
        if (!$ref) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($ref->modified_by);
        $transformer = new \VicFlora\Transformers\AgentTransformer();
        $resource = new Fractal\Resource\Item($agent, $transformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
}
