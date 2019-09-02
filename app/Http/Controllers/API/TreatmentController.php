<?php

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use VicFlora\Http\Controllers\API\ApiController;
use League\Fractal;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class TreatmentController extends ApiController
{
    protected $treatmentModel;
    
    public function __construct() {
        parent::__construct();
        $this->treatmentModel = new \VicFlora\Models\TreatmentModel();
    }
    
    /**
     * @SWG\Get(
     *     path="/treatments",
     *     tags={"Treatments"},
     *     summary="Gets descriptions",
     *     @SWG\Parameter(
     *         in="query",
     *         name="filter[taxonID]",
     *         type="string",
     *         description="Identifier (UUID) of the Taxon for which description need to be listed",
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="filter[isCurrent]",
     *         type="boolean",
     *         description="If set to true, only current descriptons will be listed",
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="exclude",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"forTaxon", "asTaxon", "acceptedNameUsage", "creator", "modifiedBy"}
     *         ),
     *         collectionFormat="csv",
     *         description="Resources that are embedded by default to exclude; multiple resources can be given, separated by a comma"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="pageSize",
     *         type="integer",
     *         format="int32",
     *         default=20,
     *         description="Number of results to list per page",
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="page",
     *         type="integer",
     *         format="int32",
     *         default=20,
     *         description="The page of results to display",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/Treatment"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid input."
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
    public function index(Request $request)
    {
        $queryParams = array_diff_key($request->all(), array_flip(['page']));
        $pageSize = (isset($queryParams['pageSize'])) 
                ? $queryParams['pageSize'] : 20;
        $this->fractal->parseIncludes(array_merge($this->fractal->getRequestedIncludes(), ['forTaxon']));
        $paginator = $this->treatmentModel->getTreatments($queryParams, true, $pageSize);
        $paginator->appends($queryParams);
        $paginatorAdapter = new IlluminatePaginatorAdapter($paginator);
        $treatments = $paginator->getCollection();
        $resource = new Fractal\Resource\Collection($treatments, 
                new \VicFlora\Transformers\TreatmentTransformer, 'treatments');
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
     * @SWG\Get(
     *     path="/treatments/{treatment}:{version}",
     *     tags={"Treatments"},
     *     summary="Gets a Treatment",
     *     @SWG\Parameter(
     *         in="path",
     *         name="treatment",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Treatment"
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         name="version",
     *         type="integer",
     *         format="int32",
     *         required=true,
     *         description="Version of the Treatment",
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="exclude",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"forTaxon", "asTaxon", "acceptedNameUsage", "creator", "modifiedBy"}
     *         ),
     *         collectionFormat="csv",
     *         description="Resources that are embedded by default to exclude; multiple resources can be given, separated by a comma"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="pageSize",
     *         type="integer",
     *         format="int32",
     *         default=20,
     *         description="Number of results to list per page",
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="page",
     *         type="integer",
     *         format="int32",
     *         default=20,
     *         description="The page of results to display",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/Treatment"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid input."
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
    public function show($id, $version)
    {
        if (!is_uuid($id) || !is_numeric($version)) {
            return $this->errorResponse(400, 
                    'Ivalid input: ID not a valid UUID or version not a valid '
                    . 'integer');
        }
        $treatment = $this->treatmentModel->getTreatment($id, $version);
        if (!$treatment) {
            return $this->errorResponse(404);
        }
        $transformer = new \VicFlora\Transformers\TreatmentTransformer();
        $this->fractal->parseIncludes(
                array_merge($this->fractal->getRequestedIncludes(), 
                        ['forTaxon']));
        $resource = new Fractal\Resource\Item($treatment, $transformer, 
                'treatments');
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
     *     path="/treatments/{treatment}:{version}/forTaxon",
     *     tags={"Treatments"},
     *     summary="Gets the Taxon to which the Treatment applies",
     *     @SWG\Parameter(
     *         in="path",
     *         name="treatment",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Treatment"
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         name="version",
     *         type="integer",
     *         format="int32",
     *         required=true,
     *         description="Version of the Treatment",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/Taxon"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     )
     * )
     * 
     * @param string $id
     * @param int $version
     * @return \Illuminate\Http\Response
     */
    public function showForTaxon($id, $version)
    {
        if (!is_uuid($id) || !is_numeric($version)) {
            return $this->errorResponse(400, 
                    'Ivalid input: ID not a valid UUID or version not a valid '
                    . 'integer');
        }
        $treatment = $this->treatmentModel->getTreatment($id, $version);
        if (!$treatment) {
            return $this->errorResponse(404);
        }
        $taxonModel = new \VicFlora\Models\TaxonModel();
        $taxon = $taxonModel->getTaxon($treatment->taxon_guid);
        $transformer = new \VicFlora\Transformers\TaxonTransformer();
        $resource = new Fractal\Resource\Item($taxon, $transformer, 'taxa');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    /**
     * @SWG\Get(
     *     path="/treatments/{treatment}:{version}/asTaxon",
     *     tags={"Treatments"},
     *     summary="Gets the Taxon for which the treatment was written",
     *     @SWG\Parameter(
     *         in="path",
     *         name="treatment",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Treatment"
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         name="version",
     *         type="integer",
     *         format="int32",
     *         required=true,
     *         description="Version of the Treatment",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/Taxon"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     )
     * )
     * 
     * @param string $id
     * @param int $version
     * @return \Illuminate\Http\Response
     */
    public function showAsTaxon($id, $version)
    {
        if (!is_uuid($id) || !is_numeric($version)) {
            return $this->errorResponse(400, 
                    'Ivalid input: ID not a valid UUID or version not a valid '
                    . 'integer');
        }
        $treatment = $this->treatmentModel->getTreatment($id, $version);
        if (!$treatment) {
            return $this->errorResponse(404);
        }
        if ($treatment->as_guid) {
            $taxonModel = new \VicFlora\Models\TaxonModel();
            $taxon = $taxonModel->getTaxon($treatment->as_guid);
            $transformer = new \VicFlora\Transformers\TaxonTransformer();
            $resource = new Fractal\Resource\Item($taxon, $transformer, 'taxa');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        else {
            return response()->json(['data' => []]);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/treatments/{treatment}:{version}/acceptedNameUsage",
     *     tags={"Treatments"},
     *     summary="Gets the Accepted Name Usage of the Taxon for which the treatment was made",
     *     @SWG\Parameter(
     *         in="path",
     *         name="treatment",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Treatment"
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         name="version",
     *         type="integer",
     *         format="int32",
     *         required=true,
     *         description="Version of the Treatment",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             ref="#/definitions/Taxon"
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     )
     * )
     * 
     * @param string $id
     * @param int $version
     * @return \Illuminate\Http\Response
     */
    public function showAcceptedNameUsage($id, $version)
    {
        if (!is_uuid($id) || !is_numeric($version)) {
            return $this->errorResponse(400, 
                    'Ivalid input: ID not a valid UUID or version not a valid '
                    . 'integer');
        }
        $treatment = $this->treatmentModel->getTreatment($id, $version);
        if (!$treatment) {
            return $this->errorResponse(404);
        }
        if ($treatment->accepted_guid) {
            $taxonModel = new \VicFlora\Models\TaxonModel();
            $taxon = $taxonModel->getTaxon($treatment->accepted_guid);
            $transformer = new \VicFlora\Transformers\TaxonTransformer();
            $resource = new Fractal\Resource\Item($taxon, $transformer, 'taxa');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        else {
            return response()->json(['data' => []]);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/treatments/{treatment}:{version}/source",
     *     tags={"Treatments"},
     *     summary="Gets a the source Reference of a Treatment",
     *     @SWG\Parameter(
     *         in="path",
     *         name="treatment",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Treatment"
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         name="version",
     *         type="integer",
     *         format="int32",
     *         required=true,
     *         description="Version of the Treatment",
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
     * @param int $version
     * @return \Illuminate\Http\Response
     */
    public function showSource($id, $version)
    {
        if (!is_uuid($id) || !is_numeric($version)) {
            return $this->errorResponse(400, 
                    'Ivalid input: ID not a valid UUID or version not a valid '
                    . 'integer');
        }
        $treatment = $this->treatmentModel->getTreatment($id, $version);
        if (!$treatment) {
            return $this->errorResponse(404);
        }
        if ($treatment->source_id) {
            $referenceModel = new \VicFlora\Models\ReferenceModel();
            $reference = $referenceModel->getReference($treatment->source_id);
            $transformer = new \VicFlora\Transformers\ReferenceTransformer();
            $resource = new Fractal\Resource\Item($reference, $transformer, 'references');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        else {
            return response()->json(['data' => []]);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/treatments/{treatment}:{version}/creator",
     *     tags={"Treatments"},
     *     summary="Gets the Agent who created the Treatment",
     *     @SWG\Parameter(
     *         in="path",
     *         name="treatment",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Treatment"
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         name="version",
     *         type="integer",
     *         format="int32",
     *         required=true,
     *         description="Version of the Treatment",
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
     * @param int $version
     * @return \Illuminate\Http\Response
     */
    public function showCreator($id, $version)
    {
        if (!is_uuid($id) || !is_numeric($version)) {
            return $this->errorResponse(400, 
                    'Ivalid input: ID not a valid UUID or version not a valid '
                    . 'integer');
        }
        $treatment = $this->treatmentModel->getTreatment($id, $version);
        if (!$treatment) {
            return $this->errorResponse(404);
        }
        if ($treatment->created_by_agent_id) {
            $agentModel = new \VicFlora\Models\AgentModel();
            $agent = $agentModel->getAgent($treatment->created_by_agent_id);
            $transformer = new \VicFlora\Transformers\ReferenceTransformer();
            $resource = new Fractal\Resource\Item($agent, $transformer, 'agents');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        else {
            return response()->json(['data' => []]);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/treatments/{treatment}:{version}/modifiedBy",
     *     tags={"Treatments"},
     *     summary="Gets the Agent who last updated a Treatment",
     *     @SWG\Parameter(
     *         in="path",
     *         name="treatment",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Treatment"
     *     ),
     *     @SWG\Parameter(
     *         in="path",
     *         name="version",
     *         type="integer",
     *         format="int32",
     *         required=true,
     *         description="Version of the Treatment",
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
     * @param int $version
     * @return \Illuminate\Http\Response
     */
    public function showModifiedBy($id, $version)
    {
        if (!is_uuid($id) || !is_numeric($version)) {
            return $this->errorResponse(400, 
                    'Ivalid input: ID not a valid UUID or version not a valid '
                    . 'integer');
        }
        $treatment = $this->treatmentModel->getTreatment($id, $version);
        if (!$treatment) {
            return $this->errorResponse(404);
        }
        if ($treatment->modified_by_agent_id) {
            $agentModel = new \VicFlora\Models\AgentModel();
            $agent = $agentModel->getAgent($treatment->modified_by_agent_id);
            $transformer = new \VicFlora\Transformers\ReferenceTransformer();
            $resource = new Fractal\Resource\Item($agent, $transformer, 'agents');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        else {
            return response()->json(['data' => []]);
        }
    }
}
