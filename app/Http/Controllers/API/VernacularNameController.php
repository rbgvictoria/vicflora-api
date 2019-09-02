<?php

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use VicFlora\Http\Controllers\API\ApiController;
use League\Fractal;

class VernacularNameController extends ApiController
{
    protected $vernacularNameModel;
    
    public function __construct() {
        parent::__construct();
        $this->vernacularNameModel = new \VicFlora\Models\VernacularNameModel();
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
     *     path="/vernacular-names/{vernacular_name}",
     *     tags={"Names"},
     *     summary="Gets a Vernacular Name record",
     *     @SWG\Parameter(
     *         in="path",
     *         name="vernacular_name",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Vernacular Name"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/VernacularName"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid input"
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
        if (!is_uuid($id)) {
            $this->errorResponse(400, 'Not a valid UUID');
        }
        $vernacularName = $this->vernacularNameModel->getVernacularName($id);
        if (!$vernacularName) {
            return $this->errorResponse(404);
        }
        $transformer = new \VicFlora\Transformers\VernacularNameTransformer();
        $resource = new Fractal\Resource\Item($vernacularName, $transformer, 
                'vernacular-names');
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
