<?php

namespace VicFlora\Http\Controllers\API\Glossary;

use Illuminate\Http\Request;
use VicFlora\Http\Controllers\API\ApiController;

class RelationshipController extends ApiController
{
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
     * Display the specified resource.
     *
     * @SWG\Get(
     *     path="/glossary/relationships/{relationship}",
     *     tags={"Glossary"},
     *     summary="Gets a glossary Term",
     *     @SWG\Parameter(
     *         in="path",
     *         name="relationship",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Relationship"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="include",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"term", "relatedTerm", "creator", "modifiedBy"}
     *         ),
     *         collectionFormat="csv",
     *         description="Extra linked resources to include in the result; multiple resources can be included, separated by a comma."
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/GlossaryRelationship"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     )
     * )
     * 
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_uuid($id)) {
            return $this->errorResponse(400, 'Not a valid UUID');
        }
        $relationshipModel = new \VicFlora\Models\Glossary\RelationshipModel();
        $relationship = $relationshipModel->getRelationship($id);
        if (!$relationship) {
            return $this->errorResponse(404);
        }
        $transformer = new \VicFlora\Transformers\GlossaryRelationshipTransformer();
        $resource = new \League\Fractal\Resource\Item($relationship, 
                $transformer, 'glossary/relatonships');
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
