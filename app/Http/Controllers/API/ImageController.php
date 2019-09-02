<?php

/*
 * Copyright 2017 Royal Botanic Gardens Victoria.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal;
use VicFlora\Http\Controllers\API\ApiController;
use VicFlora\Models\ImageModel;
use Illuminate\Support\Facades\DB;

class ImageController extends ApiController
{
    protected $imageModel;
    
    public function __construct() {
        parent::__construct();
        $this->imageModel = new ImageModel();
    }
    
    /**
     * @SWG\Get(
     *     path="/images",
     *     tags={"Images"},
     *     summary="List **Images**",
     *     produces={"application/json", "application/vnd.api+json"},
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[taxonID]",
     *       type="string",
     *       description="Filter by taxon ID; the taxon ID is a UUID; the result will include images for subordinate taxa as well, e.g. 'filter[taxonID]=dfe52d12-cc3f-4620-8a9b-ab8361322615' will include images of all species and infraspecific taxa of *Acacia*."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[taxonName]",
     *       type="string",
     *       description="Filter by taxon name; the wildcard character '__*__' can be used, for example 'Eucalyptus*' will return images for all species and infraspecific taxa of _Eucalyptus_."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[species]",
     *       type="string",
     *       description="Filter by species."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[genus]",
     *       type="string",
     *       description="Filter by genus."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="filter[family]",
     *       type="string",
     *       description="Filter by family."
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
     *         in="query",
     *         name="include",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"occurrence", "features"}
     *         ),
     *         collectionFormat="csv",
     *         description="Extra linked resources to embed in the result; multiple resources can be given separated by a comma."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="exclude",
     *       type="array",
     *       @SWG\Items(
     *         type="string",
     *         enum={"accessPoints"}
     *       ),
     *       collectionFormat="csv",
     *       description="Resources that are embedded by default to exclude from the result."
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
     *       response="200",
     *       @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *           ref="#/definitions/Image"
     *         )
     *       ),
     *       description="Successful response"
     *     ),
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
        
        $paginator = $this->imageModel->getImages($queryParams, true, $pageSize);
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
     *     path="/images/{image}",
     *     tags={"Images"},
     *     summary="Gets an **Image** resource",
     *     @SWG\Parameter(
     *       in="path",
     *       name="image",
     *       type="string",
     *       required=true,
     *       description="Identifier (UUID) of the Image"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="include",
     *         type="array",
     *         @SWG\Items(
     *             type="string",
     *             enum={"occurrence", "features"}
     *         ),
     *         collectionFormat="csv",
     *         description="Extra linked resources to embed in the result; multiple resources can be given separated by a comma."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="exclude",
     *       type="array",
     *       @SWG\Items(
     *         type="string",
     *         enum={"accessPoints"}
     *       ),
     *       collectionFormat="csv",
     *       description="Resources that are embedded by default to exclude from the result."
     *     ),
     *     @SWG\Response(
     *       response="200",
     *       @SWG\Schema(
     *           ref="#/definitions/Image"
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
        $image = $this->imageModel->getImage($id);
        if (!$image) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $transformer = new \VicFlora\Transformers\ImageTransformer();
        $resource = new Fractal\Resource\Item($image, $transformer, 'images');
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
     *     path="/images/{image}/occurrence",
     *     tags={"Images"},
     *     summary="Gets Occurrence for an **Image**",
     *     @SWG\Parameter(
     *       in="path",
     *       name="image",
     *       type="string",
     *       required=true,
     *       description="Identifier (UUID) of the Image"
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
    public function showOccurrence($id)
    {
        $image = $this->imageModel->getImage($id);
        if (!$image) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        if ($image->occurrence_id) {
            $occurrenceModel = new \VicFlora\Models\OccurrenceModel();
            $occurrence = $occurrenceModel->getOccurrence($image->occurrence_id);
            $transformer = new \VicFlora\Transformers\OccurrenceTransformer();
            $resource = new Fractal\Resource\Item($occurrence, $transformer, 'occurrences');
            $data = $this->fractal->createData($resource)->toArray();
            return response()->json($data);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/images/{image}/accessPoints",
     *     tags={"Images"},
     *     summary="Gets Access Points for an **Image**",
     *     @SWG\Parameter(
     *       in="path",
     *       name="image",
     *       type="string",
     *       required=true,
     *       description="Identifier (UUID) of the Image"
     *     ),
     *     @SWG\Response(
     *       response="200",
     *       @SWG\Schema(
     *           type="array",
     *           @SWG\Items(
     *               ref="#/definitions/AccessPoint"
     *           )
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
    public function showAccessPoints($id)
    {
        $accessPoints = $this->imageModel->getAccessPoints($id);
        if (!$accessPoints) {
            return response()->json("The requested resource could not be found", 
                    404);
        }
        $transformer = new \VicFlora\Transformers\ImageAccessPointTransformer();
        $resource = new Fractal\Resource\Collection($accessPoints, $transformer, 
                'access-points');
        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data);
    }
    
    
}
