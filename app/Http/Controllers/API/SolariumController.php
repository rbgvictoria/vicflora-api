<?php

namespace VicFlora\Http\Controllers\API;

use Illuminate\Http\Request;
use Solarium\Client;
use League\Fractal;

class SolariumController extends ApiController
{
    protected $client;
    
    protected $defaultFieldList = [
        'id',
        'taxon_rank',
        'scientific_name',
        'scientific_name_authorship',
        'taxonomic_status',
        'family',
        'occurrence_status',
        'establishment_means',
        'accepted_name_usage_id',
        'accepted_name_usage',
        'accepted_name_usage_authorship',
        'accepted_name_usage_taxon_rank',
        'name_according_to',
        'sensu',
        'taxonomic_status',
        'occurrence_status',
        'establishment_means',
        'threat_status',
        'vernacular_name'
    ];
    
    public function __construct(Client $client) {
        parent::__construct();
        $this->client = $client;
    }
    
    public function ping()
    {
        return response()->json($this->client);
        
        // create a ping query
        $ping = $this->client->createPing();

        // execute the ping query
        try {
            $this->client->ping($ping);
            return response()->json('OK');
        } catch (\Solarium\Exception $e) {
            return response()->json('ERROR', 500);
        }
    }
    
    /**
     * @SWG\Get(
     *     path="/taxa/search",
     *     tags={"Taxa"},
     *     summary="Search **Taxa**",
     *     description="This service uses the VicFlora SOLR index. SOLR has its own query syntax, see http://www.solrtutorial.com/solr-query-syntax.html for instructions on how to use it. A list of fields that is available can be found at https://vicflora.rbg.vic.gov.au/api/solr/fields.",
     *     produces={"application/json", "application/vnd.api+json"},
     *     @SWG\Parameter(
     *       in="query",
     *       name="q",
     *       type="string",
     *       required=true,
     *       default="*:*",
     *       description="The main search string; if left to the default &ndash; \*:\* &ndash; and no filter queries are used, the service will return all taxa."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="fq",
     *       type="array",
     *       @SWG\Items(
     *           type="string"
     *       ),
     *       collectionFormat="multi",
     *       description="Filter query; used to refine the initial search. Examples: 'taxon_name:Acacia\\ \*'; 'genus:Acacia'; '-taxonomic_status:accepted'. This parameter can be used multiple times in a query string."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="fl",
     *       type="array",
     *       @SWG\Items(
     *           type="string"
     *       ),
     *       collectionFormat="csv",
     *       default="id,taxon_rank,scientific_name,scientific_name_authorship,taxonomic_status,family,occurrence_status,establishment_means,accepted_name_usage_id,accepted_name_usage,accepted_name_usage_authorship,accepted_name_usage_taxon_rank,name_according_to,sensu,taxonomic_status,occurrence_status,establishment_means,threat_status,vernacular_name",
     *       description="List of fields to include; fields are separated by a comma (CSV)."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="sort",
     *       type="array",
     *       @SWG\Items(
     *           type="string"
     *       ),
     *       collectionFormat="multi",
     *       default="scientific_name asc",
     *       description="Field to sort on and the sort order ('asc' or 'desc'), separated by ' ' (space); this parameter may be used multiple times in a query string."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="rows",
     *       type="integer",
     *       format="int32",
     *       default=20,
     *       description="The number of results to return per page."
     *     ),
     *     @SWG\Parameter(
     *       in="query",
     *       name="page",
     *       type="integer",
     *       format="int32",
     *       default=1,
     *       description="The page of query results to return."
     *     ),
     *     @SWG\Response(
     *       response="200",
     *       @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *           ref="#/definitions/IndexedTaxon"
     *         )
     *       ),
     *       description="Successful response"
     *     )
     * )
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $params = \GuzzleHttp\Psr7\parse_query($request->getQueryString());
        $transform = $this->toTransformOrNotToTransform($params);
        
        $query = $this->client->createSelect();
        
        $query->setQuery((isset($params['q'])) ? $params['q'] : '*:*')
                ->setFields(isset($params['fl']) ? 
                    explode(',', $params['fl']) : $this->defaultFieldList);
        
        // sort
        $sortOrder = 'asc';
        if (isset ($params['sort'])) {
            if (!is_array($params['sort'])) {
                $params['sort'] = [$params['sort']];
            }
            foreach ($params['sort'] as $sort) {
                if (strpos($sort, ' ')) {
                    if (substr($sort, strpos($sort, ' ') + 1) == 'desc') {
                        $sortOrder = 'desc';
                    };
                    $sort = substr($sort, 0, strpos($sort, ' '));
                }
                $query->addSort($sort, $sortOrder);
            }
        }
        else {
            $query->addSort('scientific_name', $sortOrder);
        }
        
        // cursor
        $rows = 20;
        if (isset($params['rows'])) {
            $rows = $params['rows'];
        }
        $start = 0;
        if (isset($params['page'])) {
            $start = ($params['page'] - 1) * $rows;
        }
        elseif (isset($params['start'])) {
            $start = $params['start'] - ($params['start'] % $rows);
        }
        $query->setStart($start)->setRows($rows);

        
        // Filter queries
        if (isset($params['fq'])) {
            if (is_array($params['fq'])) {
                foreach ($params['fq'] as $index => $fq) {
                    $query->createFilterQuery('fq_' . $index)->setQuery($fq);
                }
            }
            else {
                $query->createFilterQuery('fq_' . 0)->setQuery($params['fq']);
            }
        }
        
        // Facets
        if (isset($params['facet.field'])) {
            $facetSet = $query->getFacetSet();
            if (is_array($params['facet.field'])) {
                foreach ($params['facet.field'] as $field) {
                    $facetSet->createFacetField($field)->setField($field);
                }
            }
            else {
                $facetSet->createFacetField($params['facet.field'])
                        ->setField($params['facet.field']);
            }
        }
        
        // Result
        $resultSet = $this->client->select($query);
        $data = [];
        foreach ($resultSet as $document) {
            $doc = [];
            foreach ($document as $field => $value) {
                $doc[$field] = $value;
            }
            $data[] = $doc;
        }
        if ($transform) {
            $transformer = new \VicFlora\Transformers\SolariumTransformer();
            $resource = new Fractal\Resource\Collection($data, $transformer, 'taxa');
            $response = $this->fractal->createData($resource)->toArray();
        }
        else {
            $response = [];
            $response['data'] = $data;
        }
        
        if (isset($params['facet.field'])) {
            $response['facets'] = [];
            foreach ($params['facet.field'] as $field) {
                $facet = $resultSet->getFacetSet()->getFacet($field);
                foreach ($facet as $value => $count) {
                    $response['facets'][$field][$value] = $count;
                }
                
            }
        }
        
        $response['meta']['params'] = $params;
        $response['meta']['pagination'] = $this->pagination($resultSet, $params);
        if ($transform && $request->header('accept') == 'application/vnd.api+json') {
            $response['links'] = $this->pagination_links($resultSet, $params);
        }
        else {
            $response['meta']['pagination']['links'] = $this->pagination_links($resultSet, $params);
        }
        
        $response['meta']['solrUri'] = urldecode($this->client->createRequest($query)->getUri());
        
        return response()->json($response);
    }
    
    /**
     * 
     * @SWG\Get(
     *     path="/solr/fields",
     *     tags={"SOLR"},
     *     summary="Fields in the SOLR index",
     *     description="This uses the SOLR index.",
     *     produces={"application/json"},
     *     @SWG\Response(
     *       response="200",
     *       @SWG\Schema(
     *         type="array",
     *         @SWG\Items(
     *           type="object",
     *           @SWG\Property(
     *               property="solrField",
     *               type="string",
     *               description="Field name used in the SOLR index; use these names to interact with the index."
     *           ),
     *           @SWG\Property(
     *               property="outputField",
     *               type="string",
     *               description="Field name used in the result output."
     *           )
     *         )
     *       ),
     *       description="Successful response"
     *     ),
     * )
     */
    public function solrFields()
    {
        $fields = [
            [
                    'solrField' => 'id',
                    'outputField' => 'taxonID'
            ],
            [
                    'solrField' => 'taxon_rank',
                    'outputField' => 'taxonRank'
            ],
            [
                    'solrField' => 'scientific_name_id',
                    'outputField' => 'scientificNameID'
            ],
            [
                    'solrField' => 'scientific_name',
                    'outputField' => 'scientificName'
            ],
            [
                    'solrField' => 'scientific_name_authorship',
                    'outputField' => 'scientificNameAuthorship'
            ],
            [
                    'solrField' => 'name_published_in_id',
                    'outputField' => 'namePublishedInID'
            ],
            [
                    'solrField' => 'name_published_in',
                    'outputField' => 'namePublishedIn'
            ],
            [
                    'solrField' => 'name_published_in_year',
                    'outputField' => 'namePublishedInYear'
            ],
            [
                    'solrField' => 'sensu',
                    'outputField' => 'nameAccordingTo'
            ],
            [
                    'solrField' => 'kingdom',
                    'outputField' => 'kingdom'
            ],
            [
                    'solrField' => 'phylum',
                    'outputField' => 'phylum'
            ],
            [
                    'solrField' => 'class',
                    'outputField' => 'class'
            ],
            [
                    'solrField' => 'order',
                    'outputField' => 'order'
            ],
            [
                    'solrField' => 'family',
                    'outputField' => 'family'
            ],
            [
                    'solrField' => 'genus',
                    'outputField' => 'genus'
            ],
            [
                    'solrField' => 'specific_epithet',
                    'outputField' => 'specificEpithet'
            ],
            [
                    'solrField' => 'infraspecific_epithet',
                    'outputField' => 'infraspecificEpithet'
            ],
            [
                    'solrField' => 'parent_name_usage_id',
                    'outputField' => 'parentNameUsageID'
            ],
            [
                    'solrField' => 'parent_name_usage',
                    'outputField' => 'parentNameUsage'
            ],
            [
                    'solrField' => 'accepted_name_usage_id',
                    'outputField' => 'acceptedNameUsageID'
            ],
            [
                    'solrField' => 'accepted_name_usage',
                    'outputField' => 'acceptedNameUsage'
            ],
            [
                    'solrField' => 'original_name_usage_id',
                    'outputField' => 'originalNameUsageID'
            ],
            [
                    'solrField' => 'original_name_usage',
                    'outputField' => 'originalNameUsage'
            ],
            [
                    'solrField' => 'nomenclatural_status',
                    'outputField' => 'nomenclaturalStatus'
            ],
            [
                    'solrField' => 'taxonomic_status',
                    'outputField' => 'taxonomicStatus'
            ],
            [
                    'solrField' => 'occurrence_status',
                    'outputField' => 'occurrenceStatus'
            ],
            [
                    'solrField' => 'establishment_means',
                    'outputField' => 'establishmentMeans'
            ],
            [
                    'solrField' => 'threat_status',
                    'outputField' => 'threatStatus'
            ],
            [
                    'solrField' => 'taxon_remarks',
                    'outputField' => 'taxonRemarks'
            ],
            [
                    'solrField' => 'ibra_7_subregion',
                    'outputField' => '[bioregions]'
            ],
            [
                    'solrField' => 'nrm_region',
                    'outputField' => '[nrmRegions]'
            ],
            [
                    'solrField' => 'vernacular_name',
                    'outputField' => 'vernacularName'
            ],
        ];
        return response()->json($fields);
    }
    
    protected function toTransformOrNotToTransform($params) 
    {
        $transform = true;
        if (isset($params['transform']) && $params['transform'] == 'false') {
            $transform = false;
        }
        return $transform;
    }
    
    protected function pagination($result, $params)
    {
        $total = $result->getNumFound();
        $perPage = 20;
        if (isset($params['rows'])) {
            $perPage = $params['rows'];
        }
        $page = 1;
        if (isset($params['page'])) {
            $page = $params['page'];
        }
        elseif (isset($params['start'])) {
            $page = floor($params['start'] / $perPage);
        }
        $pagination = [
            'total' => $total,
            'count' => $total % $perPage,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => ceil($total / $perPage)
        ];
        return $pagination;
    }
    
    protected function pagination_links($result, $params=[])
    {
        $url = secure_url(request()->path());
        
        $perPage = 20;
        if (isset($params['rows'])) {
            $perPage = $params['rows'];
            unset($params['rows']);
        }
        $params['rows'] = $perPage;
        
        $page = 1;
        if (isset($params['page'])) {
            $page = $params['page'];
            unset($params['page']);
        }
        elseif (isset($params['start'])) {
            $page = floor($params['start'] / $perPage);
            unset($params['start']);
        }
        
        $links = [];
        $links['self'] = $url . '?' . \GuzzleHttp\Psr7\build_query($params) . '&page=' . $page;
        $links['first'] = $url . '?' . \GuzzleHttp\Psr7\build_query($params) . '&page=1';
        if ($page > 1) {
            $links['prev'] = $url . '?' . \GuzzleHttp\Psr7\build_query($params) . '&page=' . ($page - 1);
        }
        $numPages = ceil($result->getNumFound() / $perPage);
        if ($page < $numPages) {
            $links['next'] = $url . '?' . \GuzzleHttp\Psr7\build_query($params) . '&page=' . ($page + 1);
        }
        $links['last'] = $url . '?' . \GuzzleHttp\Psr7\build_query($params) . '&page=' . $numPages;
        return $links;
    }
}
