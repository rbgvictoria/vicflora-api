<?php

/*
 * Copyright 2017 Niels Klazenga, Royal Botanic Gardens Victoria.
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

namespace VicFlora\Models;

use Solarium\Client;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\SolariumAdapter;


/**
 * Description of SolariumModel
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class SolariumModel {
    
    protected $client;
    protected $query;
    protected $request;
    protected $resultSet;
    protected $params;
    
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
        'profile',
        'vernacular_name'
    ];
    
    public function __construct() {
        $this->client = new Client();
    }
    
    public function search($params) {
        $this->createQuery($params);
        
        $adapter = new SolariumAdapter($this->client, $this->query);
        $pagerfanta = new Pagerfanta($adapter);
        return $pagerfanta;
    }




    public function createQuery($params)
    {
        $this->params = $params;
        $this->query = $this->client->createSelect();
        $this->setQuery();
        $this->setFields();
        $this->setFilterQueries();
        $this->setStart();
        $this->setRows();
        $this->setFacetFields();
    }
    
    protected function setQuery()
    {
        if (!isset($this->params['q'])) {
            $this->params['q'] = '*:*';
        }
        $this->query->setQuery($this->params['q']);
    }
    
    protected function setFilterQueries()
    {
        if (isset($this->params['fq'])) {
            foreach ($this->params['fq'] as $index => $fq) {
                $this->query->createFilterQuery('fq_' . $index)->setQuery($fq);
            }
        }
    }
    
    protected function setFields()
    {
        if (isset($this->params['fl'])) {
            $this->query->setFields(explode(',', $this->params['fl']));
        }
        else {
            $this->query->setFields($this->defaultFieldList);
        }
    }
    
    protected function setStart()
    {
        if (isset($this->params['start'])) {
            $this->query->setStart($this->params['start']);
        }
    }
    
    protected function setRows($rows = 20)
    {
        if (isset($this->params['rows'])) {
            $this->query->setRows($this->params['rows']);
        }
        else {
            $this->query->setRows($rows);
        }
    }
    
    protected function setFacetFields()
    {
        if (isset($this->params['facet.field'])) {
            $facetSet = $this->query->getFacetSet();
            foreach ($this->params['facet.field'] as $field) {
                $facetSet->createFacetField($field)->setField($field);
            }
        }
    }
    
    public function getDocs()
    {
        $docs = [];
        foreach ($this->resultSet as $document) {
            $doc = [];
            foreach ($document as $field => $value) {
                $doc[$field] = $value;
            }
            $docs[] = $doc;
        }
        return $docs;
    }
    
    public function getFacets()
    {
        $facets = [];
        foreach ($this->params['facet.field'] as $field) {
            $facet = $this->resultSet->getFacetSet()->getFacet($field);
            foreach ($facet as $value => $count) {
                $facets[$field][$value] = $count;
            }
        }
        return $facets;
    }
    
    
}
