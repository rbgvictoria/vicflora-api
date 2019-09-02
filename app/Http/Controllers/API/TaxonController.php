<?php

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use VicFlora\Http\Controllers\API\ApiController;
use League\Fractal;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use GuzzleHttp\Client;


class TaxonController extends ApiController
{
    protected $taxonModel;
    
    public function __construct() {
        parent::__construct();
        $this->taxonModel = new \VicFlora\Models\TaxonModel();
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
     *     path="/taxa/{taxon}",
     *     tags={"Taxa"},
     *     summary="Gets a **Taxon** resource",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         required=true,
     *         type="string",
     *         description="UUID of the **Taxon** resource"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="include",
     *         type="array",
     *         items=@SWG\Items(
     *             type="string",
     *             enum={"creator", "modifiedBy", "hasParentNameUsage", 
     *                 "classification", "siblings", "children", "synonyms", 
     *                 "treatments", "changes", "bioregionDistribution", 
     *                 "stateDistribution"}
     *         ),
     *         collectionFormat="csv",
     *         description="Extra linked resources to include in the result; linked resources within included resources can be appended, separated by a full stop, e.g. 'treatment.as'; multiple resources can be included, separated by a comma."
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="exclude",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"hasScientificName", "hasAcceptedNameUsage", "nameAccordingTo"}
     *         ),
     *         collectionFormat="csv",
     *         description="Linked resources to exclude from the result; the enumerated resources are included by default, but can be excluded if they are not wanted in the result."
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
     *         description="The requested resource could not be found"
     *     )
     * )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $taxon = $this->taxonModel->getTaxon($id);
        if (!$taxon) {
            return response()->json('The requested resource could not be found', 
                    404);
        }
        $transformer = new \VicFlora\Transformers\TaxonTransformer();
        $resource = new \League\Fractal\Resource\Item($taxon, $transformer, 'taxa');
        $include = 'name.namePublishedIn';
        if (request()->input('include')) {
            $include .= ',' . \request()->input('include');
        }
        $this->fractal->parseIncludes($include);
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
     *     path="/taxa/{taxon}/name",
     *     tags={"Taxa"},
     *     summary="Gets the Name record for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
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
    public function hasScientificName($id)
    {
        $taxon = $this->taxonModel->getTaxon($id);
        if (!$taxon) {
            return response()->json('The requested resource could not be found', 
                    404);
        }
        $nameModel = new \VicFlora\Models\NameModel();
        $name = $nameModel->getName($taxon->scientific_name_id);
        $transformer = new \VicFlora\Transformers\NameTransformer();
        $resource = new Fractal\Resource\Item($name, $transformer, 'names');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/nameAccordingTo",
     *     tags={"Taxa"},
     *     summary="Gets the Reference for a Name Usage (""sensu"")",
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
    public function showNameAccordingTo($id)
    {
        $taxon = $this->taxonModel->getTaxon($id);
        if (!$taxon) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        if ($taxon->name_according_to_id) {
            $referenceModel = new \VicFlora\Models\ReferenceModel();
            $nameAccordingTo = $referenceModel->getReference($taxon->name_according_to_id);
            $transformer = new \VicFlora\Transformers\ReferenceTransformer();
            $resource = new Fractal\Resource\Item($nameAccordingTo, $transformer, 
                    'references');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
    }

    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/classification",
     *     tags={"Taxa"},
     *     summary="Gets classification for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/Taxon"
     *             )
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
    public function classification($id)
    {
        $taxa = $this->taxonModel->getHigherClassification($id);
        if ($taxa) {
            $transformer = new \VicFlora\Transformers\TaxonTransformer();
            $resource = new Fractal\Resource\Collection($taxa, $transformer, 'taxa');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        return response()->json($taxa);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/children",
     *     tags={"Taxa"},
     *     summary="Gets children of a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/Taxon"
     *             )
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
    public function children($id)
    {
        $children = $this->taxonModel->getChildren($id);
        if ($children) {
            $transformer = new \VicFlora\Transformers\TaxonTransformer();
            $resource = new Fractal\Resource\Collection($children, $transformer, 'taxa');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        return response()->json($children);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/siblings",
     *     tags={"Taxa"},
     *     summary="Gets siblings of a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/Taxon"
     *             )
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
    public function siblings($id)
    {
        $siblings = $this->taxonModel->getSiblings($id);
        if ($siblings) {
            $transformer = new \VicFlora\Transformers\TaxonTransformer();
            $resource = new Fractal\Resource\Collection($siblings, $transformer, 'taxa');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        return response()->json($siblings);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/synonyms",
     *     tags={"Taxa"},
     *     summary="Gets synonyms for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/Taxon"
     *             )
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
    public function synonyms($id)
    {
        $synonyms = $this->taxonModel->getSynonyms($id);
        if ($synonyms) {
            $transformer = new \VicFlora\Transformers\TaxonTransformer();
            $resource = new Fractal\Resource\Collection($synonyms, $transformer, 'taxa');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        return response()->json($synonyms);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/acceptedNameUsage",
     *     tags={"Taxa"},
     *     summary="Gets accepted name usage of a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
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
     * @return \Illuminate\Http\Response
     */
    public function hasAcceptedNameUsage($id)
    {
        if (!is_uuid($id)) {
            return $this->errorResponse(400, 'Not a valid UUID');
        }
        $taxon = $this->taxonModel->getTaxon($id);
        if (!$taxon) {
            return $this->errorResponse(404);
        }
        if ($taxon->accepted_name_usage_id) {
            $accepted = $this->taxonModel->getTaxon($taxon->accepted_name_usage_id);
            $transformer = new \VicFlora\Transformers\TaxonTransformer();
            $resource = new Fractal\Resource\Item($accepted, $transformer, 'taxa');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
    }

    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/parentNameUsage",
     *     tags={"Taxa"},
     *     summary="Gets parent of a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
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
     * @return \Illuminate\Http\Response
     */
    public function hasParentNameUsage($id)
    {
        if (!is_uuid($id)) {
            return $this->errorResponse(400, 'Not a valid UUID');
        }
        $taxon = $this->taxonModel->getTaxon($id);
        if (!$taxon) {
            return $this->errorResponse(404);
        }
        if ($taxon->parent_name_usage_id) {
            $parent = $this->taxonModel->getTaxon($taxon->parent_name_usage_id);
            $transformer = new \VicFlora\Transformers\TaxonTransformer();
            $resource = new Fractal\Resource\Item($parent, $transformer, 'taxa');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/changes",
     *     tags={"Taxa"},
     *     summary="Gets changes for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/Change"
     *             )
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
    public function changes($id)
    {
        $params = ['filter' => ['fromTaxonID' => $id]];
        $changeModel = new \VicFlora\Models\ChangeModel();
        $changes = $changeModel->getChanges($params, false);
        $resource = new Fractal\Resource\Collection($changes, 
                new \VicFlora\Transformers\ChangeTransformer, 'changes');
        $data = $this->fractal->createData($resource)->toArray();
        $data['meta']['queryParams'] = $params;
        return response()->json($data);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/treatments",
     *     tags={"Taxa"},
     *     summary="Gets descriptions for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="include",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"forTaxon"}
     *         ),
     *         collectionFormat="csv",
     *         description="Extra linked resources to include; multiple resources can be added, separated by a comma."
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="exclude",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"asTaxon", "acceptedNameUsage", "creator", "modifiedBy"}
     *         ),
     *         collectionFormat="csv",
     *         description="Resources that are embedded by default to exclude; multiple resources can be given, separated by a comma"
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
    public function treatments($id)
    {
        $params = ['filter' => ['taxonID' => $id]];
        $treatmentModel = new \VicFlora\Models\TreatmentModel();
        $treatments = $treatmentModel->getTreatments($params, false);
        $resource = new Fractal\Resource\Collection($treatments, 
                new \VicFlora\Transformers\TreatmentTransformer(), 'treatments');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/currentTreatment",
     *     tags={"Taxa"},
     *     summary="Gets current description for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="include",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"forTaxon"}
     *         ),
     *         collectionFormat="csv",
     *         description="Extra linked resources to include; multiple resources can be added, separated by a comma."
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="exclude",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"asTaxon", "acceptedNameUsage", "creator", "modifiedBy"}
     *         ),
     *         collectionFormat="csv",
     *         description="Resources that are embedded by default to exclude; multiple resources can be given, separated by a comma"
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
    public function currentTreatment($id) 
    {
        $params = [
            'filter' => [
                'taxonID' => $id,
                'isCurrent' => 'true'
            ]
        ];
        $treatmentModel = new \VicFlora\Models\TreatmentModel();
        $treatments = $treatmentModel->getTreatments($params, false);
        if ($treatments) {
            $resource = new Fractal\Resource\Item($treatments[0], 
                    new \VicFlora\Transformers\TreatmentTransformer(), 'treatments');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
    }
    
    public function showHeroImage($id)
    {
        if (!is_uuid($id)) {
            return $this->errorResponse(400, "Not a valid UUID");
        }
        $imageModel = new \VicFlora\Models\ImageModel();
        $heroImage = $imageModel->getHeroImage($id);
        if (!$heroImage) {
            return $this->errorResponse('404', "Hero image is only available "
                    . "for accepted taxa at the rank of family and below.");
        }
        $transformer = new \VicFlora\Transformers\ImageTransformer();
        $transformer->setDefaultIncludes(['accessPoints']);
        $resource = new Fractal\Resource\Item($heroImage, $transformer, 'images');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/bioregionDistribution",
     *     tags={"Taxa"},
     *     summary="Gets Victorian bioregions for a Taxon",
     *     description="Returns Victorian bioregions (IBRA7 subregions) in which the specified Taxon occurs.",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/TaxonArea"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Distribution is only available for accepted taxa of species or lower rank."
     *     )
     * )
     * 
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function distribution($id)
    {
        $taxon = $this->taxonModel->getTaxonInclude($id);
        if ($taxon->taxonomic_status == 'accepted' &&
                in_array($taxon->rank, ['species', 'subspecies', 'variety', 
                    'subvariety', 'forma', 'subforma', 'nothosubspecies', 
                    'nothovariety'])) {
            
            $distributionModel = new \VicFlora\Models\DistributionModel();
            $distribution = $distributionModel->getBioregionsForTaxon($id, 
                    $taxon->rank);
            $transformer = new \VicFlora\Transformers\TaxonAreaTransformer();
            $resource = new Fractal\Resource\Collection($distribution, 
                    $transformer, 'areas');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        else {
            return response()->json("Distribution is only available for "
                    . "accepted taxa of species or lower rank", 400);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/stateDistribution",
     *     tags={"Taxa"},
     *     summary="Gets state distribution for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/TaxonArea"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="The requested resource could not be found."
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Distribution is only available for accepted taxa of species or lower rank."
     *     )
     * )
     * 
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function stateDistribution($id)
    {
        $taxon = $this->taxonModel->getTaxonInclude($id);
        if ($taxon->taxonomic_status == 'accepted' &&
                in_array($taxon->rank, ['species', 'subspecies', 'variety', 
                    'subvariety', 'forma', 'subforma', 'nothosubspecies', 
                    'nothovariety'])) {
            $distributionModel = new \VicFlora\Models\DistributionModel();
            $distribution = $distributionModel->getStateDistributionForTaxon(
                    $id, $taxon->rank);
            $transformer = new \VicFlora\Transformers\TaxonAreaTransformer();
            $resource = new Fractal\Resource\Collection($distribution, 
                    $transformer, 'areas');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
        else {
            return response()->json("Distribution is only available for "
                    . "accepted taxa of species or lower rank", 400);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/images",
     *     tags={"Taxa"},
     *     summary="Gets images for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[subtype]",
     *       type="string",
     *       enum={"illustration", "photograph"},
     *       description="Filter by subtype."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[license]",
     *       type="string",
     *       description="Filter by licence; parameter can take a wildcard ('__*__'), for example '__*__' will return all images that have a licence."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[features]",
     *       type="array",
     *       @SWG\Items(
     *         type="string",
     *       ),
     *       collectionFormat="csv",
     *       description="Filter on features in the image; values from the feature vocabulary."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[hero]",
     *       type="string",
     *       enum={"true"},
     *       description="Filter on hero images; only recognised value is ""true""."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[creator]",
     *       type="string",
     *       description="Filter on creator; the wildcard character '__*__' may be used."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="exclude",
     *       type="array",
     *       @SWG\Items(
     *         type="string",
     *         enum={"accessPoints", "occurrence", "features"}
     *       ),
     *       collectionFormat="csv",
     *       description="Linked resources to exclude from the response."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="sort",
     *       type="array",
     *       @SWG\Items(
     *         type="string",
     *         enum={"scientificName", "-scientificName", "subtype", "-subtype", "subjectCategory", "-subjectCategory", "license", "-license", "rating", "-rating", "creator", "-creator", "createDate", "-createDate", "digitizationDate", "-digitizationDate"}
     *       ),
     *       collectionFormat="csv",
     *       description="Terms to sort the results by; you can sort by multiple terms at the same time; prefix a term with a '-' to sort in descending order. **Note that applying sorting appears to break the Swagger UI, but works perfectly well in other clients (there might be an AJAX issue).**"
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
     *                 ref="#/definitions/Image"
     *             )
     *         )
     *     )
     * )
     * 
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function images(Request $request, $id) {
        $imageModel = new \VicFlora\Models\ImageModel();

        $queryParams = array_diff_key($request->all(), array_flip(['page']));
        $params = $queryParams;
        $params['filter']['taxonID'] = $id;
        $pageSize = (isset($queryParams['pageSize'])) 
                ? $queryParams['pageSize'] : 20;
        
        $paginator = $imageModel->getImages($params, true, $pageSize);
        $paginator->appends($queryParams);
        $paginatorAdapter = new IlluminatePaginatorAdapter($paginator);
        $images = $paginator->getCollection();
        $resource = new Fractal\Resource\Collection($images, 
                new \VicFlora\Transformers\ImageTransformer, 'images');
        $resource->setPaginator($paginatorAdapter);
        $data = $this->fractal->createData($resource)->toArray();
        $data['meta']['queryParams'] = $queryParams;
        return $this->responseWithRedirectMessage($data);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/references",
     *     tags={"Taxa"},
     *     summary="Gets References for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/Agent"
     *             )
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
    public function showReferences($id)
    {
        if (!is_uuid($id)) {
            return $this->errorResponse(400, 'Not a valid UUID');
        }
        $referenceModel = new \VicFlora\Models\ReferenceModel();
        $references = $referenceModel->getTaxonReferences($id);
        if ($references) {
            $transformer = new \VicFlora\Transformers\ReferenceTransformer();
            $resource = new Fractal\Resource\Collection($references, $transformer, 'references');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/key",
     *     tags={"Taxa"},
     *     summary="Gets Key for a Taxon",
     *     description="Gets the key from KeyBase.",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
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
    public function findKey($id)
    {
        if (!is_uuid($id)) {
            return $this->errorResponse(400, 'Not a valid UUID');
        }
        $taxon = $this->taxonModel->getTaxonInclude($id);
        if (!$taxon) {
            return $this->errorResponse(404);
        }
        $client = new Client([
            'base_uri' => 'http://keybase.rbg.vic.gov.au/ws/'
        ]);
        $response = $client->request('GET', 'keys', [
            'query' => [
                'project' => 10,
                'tscope' => $taxon->full_name
            ]
        ]);
        
        if ($response->hasHeader('Content-Length')) {
            $length = $response->getHeader("Content-Length");
            if ($length[0] > '0') {
                $body = \GuzzleHttp\json_decode($response->getBody());
                $key = $body->Items[0]->KeysID;
                return $this->getKey($key);
            }
        }
    }
    
    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getKey($key)
    {
        if (!is_numeric($key)) {
            return $this->errorResponse(400, 'Not a valid ID');
        }
        $client = new Client([
            'base_uri' => 'http://data.rbg.vic.gov.au/keybase-ws/ws/'
        ]);
        $response = $client->request('GET', 'key_get/' . $key);
        $body = json_decode($response->getBody());
        if (!isset($body->key_id)) {
            return $this->errorResponse(404);
        }
        return response()->json($body);
    }

    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/creator",
     *     tags={"Taxa"},
     *     summary="Gets creator of a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
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
        $taxon = $this->taxonModel->getTaxon($id);
        if (!$taxon) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($taxon->creator);
        $transformer = new \VicFlora\Transformers\AgentTransformer();
        $resource = new Fractal\Resource\Item($agent, $transformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }

    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/modifiedBy",
     *     tags={"Taxa"},
     *     summary="Gets Agent who last modified a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
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
        $taxon = $this->taxonModel->getTaxon($id);
        if (!$taxon) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($taxon->modified_by);
        $transformer = new \VicFlora\Transformers\AgentTransformer();
        $resource = new Fractal\Resource\Item($agent, $transformer, 'agents');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/{taxon}/vernacularNames",
     *     tags={"Taxa"},
     *     summary="Gets vernacular names for a Taxon",
     *     @SWG\Parameter(
     *         in="path",
     *         name="taxon",
     *         type="string",
     *         required=true,
     *         description="Identifier (UUID) of the Taxon"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Successful response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(
     *                 ref="#/definitions/VernacularName"
     *             )
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
    public function listVernacularNames($id)
    {
        $model = new \VicFlora\Models\VernacularNameModel();
        $vernacularNames = $model->getVernacularNames($id);
        $transformer = new \VicFlora\Transformers\VernacularNameTransformer();
        $resource = new Fractal\Resource\Collection($vernacularNames, 
                $transformer, 'vernacular-names');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
}
