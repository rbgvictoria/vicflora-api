<?php

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use VicFlora\Http\Controllers\API\ApiController;
use League\Fractal;

class NameController extends ApiController
{
    protected $nameModel;
    
    public function __construct() {
        parent::__construct();
        $this->nameModel = new \VicFlora\Models\NameModel();
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
     *     path="/names/{name}",
     *     tags={"Names"},
     *     summary="Gets a Name record",
     *     @SWG\Parameter(
     *         in="path",
     *         name="name",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Name"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/Name"
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
        $name = $this->nameModel->getName($id);
        if (!$name) {
            return response()->json('The requested resource could not be found', 
                    404);
        }
        $transformer = new \VicFlora\Transformers\NameTransformer();
        $resource = new Fractal\Resource\Item($name, $transformer, 'names');
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
     *     path="/names/{name}/namePublishedIn",
     *     tags={"Names"},
     *     summary="Gets the protologue for a Name",
     *     @SWG\Parameter(
     *         in="path",
     *         name="name",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Name"
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
    public function showNamePublishedIn($id)
    {
        $name = $this->nameModel->getName($id);
        if (!$name) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        if ($name->name_published_in) {
            $referenceModel = new \VicFlora\Models\ReferenceModel();
            $publishedIn = $referenceModel->getReference($name->name_published_in);
            $transformer = new \VicFlora\Transformers\ReferenceTransformer();
            $resource = new Fractal\Resource\Item($publishedIn, $transformer, 
                    'references');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/names/{name}/creator",
     *     tags={"Names"},
     *     summary="Gets creator of a Name",
     *     @SWG\Parameter(
     *         in="path",
     *         name="name",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Name"
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
        $name = $this->nameModel->getName($id);
        if (!$name) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($name->creator);
        $transformer = new \VicFlora\Transformers\AgentTransformer();
        $resource = new Fractal\Resource\Item($agent, $transformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }

    /**
     * @SWG\Get(
     *     path="/names/{name}/modifiedBy",
     *     tags={"Names"},
     *     summary="Gets Agent who last modified a Name",
     *     @SWG\Parameter(
     *         in="path",
     *         name="agent",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Name"
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
        $name = $this->nameModel->getName($id);
        if (!$name) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($name->modified_by);
        $transformer = new \VicFlora\Transformers\AgentTransformer();
        $resource = new Fractal\Resource\Item($agent, $transformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
}
