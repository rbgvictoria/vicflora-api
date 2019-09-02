<?php

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use VicFlora\Http\Controllers\API\ApiController;

class OccurrenceController extends ApiController
{
    protected $occurrenceModel;
    
    public function __construct() {
        parent::__construct();
        $this->occurrenceModel = new \VicFlora\Models\OccurrenceModel();
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
     *     path="/occurrences/{occurrence}",
     *     tags={"Images"},
     *     summary="Gets Occurrence for an **Image**",
     *     @SWG\Parameter(
     *       in="path",
     *       name="occurrence",
     *       type="string",
     *       required=true,
     *       description="Identifier (UUID) of the Occurrence"
     *     ),
     *     @SWG\Response(
     *       response="200",
     *       @SWG\Schema(
     *           ref="#/definitions/Occurrence"
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
        $occurrence = $this->occurrenceModel->getOccurrence($id);
        if (!$occurrence) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $transformer = new \VicFlora\Transformers\OccurrenceTransformer();
        $resource = new \League\Fractal\Resource\Item($occurrence, $transformer, 'occurrences');
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
