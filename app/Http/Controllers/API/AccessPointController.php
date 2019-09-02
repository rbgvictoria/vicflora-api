<?php

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use VicFlora\Http\Controllers\API\ApiController;
use League\Fractal;
use Illuminate\Database\QueryException;

class AccessPointController extends ApiController
{
    protected $accessPointModel;
    
    public function __construct() {
        parent::__construct();
        $this->accessPointModel = new \VicFlora\Models\AccessPointModel;
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
     *     path="/access-points/{access_point}",
     *     tags={"Images"},
     *     summary="Gets Access Points for an **Image**",
     *     @SWG\Parameter(
     *       in="path",
     *       name="access_point",
     *       type="string",
     *       required=true,
     *       description="Identifier (UUID) of the Access Point"
     *     ),
     *     @SWG\Response(
     *       response="200",
     *       @SWG\Schema(
     *           ref="#/definitions/AccessPoint"
     *       ),
     *       description="Successful response"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found"
     *     )
     * )
     * 
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_uuid($id)) {
            return $this->errorResponse(400, "Not a valid UUID");
        }
        $accessPoint = $this->accessPointModel->getAccessPoint($id);
        if (!$accessPoint) {
            return $this->errorResponse(404);
        }
        $transformer = new \VicFlora\Transformers\ImageAccessPointTransformer();
        $resource = new Fractal\Resource\Item($accessPoint, $transformer, 'access-points');
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
