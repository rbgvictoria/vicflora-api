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

namespace VicFlora\Models;

use Illuminate\Support\Facades\DB;

/**
 * Description of ImageModel
 *
 * @author nklazenga
 */
class ImageModel 
{
    
    public function getImages($queryParams, $pagination=true, $pageSize=20)
    {
        $sort = isset($queryParams['sort']) ? $queryParams['sort'] : false;
        
        $query = $this->imageQuery();
        
        if (isset($queryParams['filter'])) {
            $query = $this->filter($query, $queryParams['filter']);
        }
        
        $query->when($sort, function($query) use ($sort) {
            return $this->sort($query, $sort);
        });
        
        return $this->pagination($query, $pagination, $pageSize);
    }
    
    public function getImage($id)
    {
        $query = $this->imageQuery();
        $query = $query->where('i.guid', $id)
                ->first();
        return $query;
    }
    
    public function getHeroImage($taxon)
    {
        $nodeNumber = null;
        $highestDescendantNodeNumber = null;
        $node = DB::table('flora.taxa as t')
                ->select('tr.node_number', 'tr.highest_descendant_node_number')
                ->join('flora.taxon_tree as tr', 't.id', '=', 'tr.taxon_id')
                ->where('t.guid', '=', $taxon)
                ->first();
        if ($node) {
            $nodeNumber = $node->node_number;
            $highestDescendantNodeNumber = $node->highest_descendant_node_number;
        }
        $query = $this->imageQuery();
        return $query->join('flora.taxon_tree as tr', 't.id', '=', 'tr.taxon_id')
                ->where('tr.node_number', '>=', $nodeNumber)
                ->where('tr.highest_descendant_node_number', '<=',
                        $highestDescendantNodeNumber)
                ->orderBy('i.is_hero_image', 'desc')
                ->orderBy('v_st.name', 'desc')
                ->orderBy('i.rating', 'desc')
                ->orderBy(DB::raw('random()'))
                ->first();
    }
    
    protected function filter($query, $filter) {
        $query->when(isset($filter['taxonID']), function($query) use ($filter) {
            $nodeNumber = null;
            $highestDescendantNodeNumber = null;
            $node = DB::table('flora.taxa as t')
                    ->select('tr.node_number', 'tr.highest_descendant_node_number')
                    ->join('flora.taxon_tree as tr', 't.id', '=', 'tr.taxon_id')
                    ->where('t.guid', '=', $filter['taxonID'])
                    ->first();
            if ($node) {
                $nodeNumber = $node->node_number;
                $highestDescendantNodeNumber = $node->highest_descendant_node_number;
            }
            return $query->join('flora.taxon_tree as tr', 't.id', '=', 'tr.taxon_id')
                    ->where('tr.node_number', '>=', $nodeNumber)
                    ->where('tr.highest_descendant_node_number', '<=',
                            $highestDescendantNodeNumber);
        });
        
        $query->when(isset($filter['taxonName']), 
                function($query) use ($filter) {
            $taxonName = str_replace('*', '%', urldecode($filter['taxonName']));
            return $query->where('an.full_name', 'like', $taxonName);
        });
        
        $query->when(isset($filter['species']), function($query) use ($filter) {
            $species = urldecode($filter['species']);
            return $this->higherTaxonSearch($query, $species, 'species');
        });
        
        $query->when(isset($filter['genus']), function($query) use ($filter) {
            return $this->higherTaxonSearch($query, $filter['genus'], 'genus');
        });
        
        $query->when(isset($filter['family']), function($query) use ($filter) {
            return $this->higherTaxonSearch($query, $filter['family'], 'family');
        });
        
        $query->when(isset($filter['license']), function($query) use ($filter) {
            $license = str_replace('*', '%', urldecode($filter['license']));
            return $query->where('v_l.name', 'like', $license);
        });
        
        $query->when(isset($filter['subtype']), function($query) use ($filter) {
            return $query->where('v_st.name', $filter['subtype']);
        });
        
        $query->when(isset($filter['subjectCategory']), 
                function($query) use ($filter) {
            return $query->where('v_sc.name', $filter['subjectCategory']);
        });
        
        $query->when(isset($filter['features']), 
                function($query) use ($filter) {
            return $this->featureSearch($query, $filter['features']);
        });
        
        $query->when(isset($filter['minRating']), function($query) 
                use ($filter) {
            $minRating = (integer) $filter['minRating'];
            return $query->whereRaw('i.rating>=' . $minRating);
        });
        
        $query->when(isset($filter['hero']), function($query) {
            return $query->where('i.is_hero_image', true);
        });
        
        $query->when(isset($filter['creator']), function($query) use ($filter) {
            $creator = str_replace('*', '%', urldecode($filter['creator']));
            return $query->where('a.name', 'like', $creator);
        });

        return $query;        
    }
    
    public function getAccessPoints($imageId)
    {
        return DB::table('images.image_access_points as a')
                ->select('a.id', 'a.guid as access_point_id', 'v.name as variant', 
                        'a.access_uri', 'a.format', 'a.pixel_x_dimension', 
                        'a.pixel_y_dimension')
                ->join('images.images as i', 'a.image_id', '=', 'i.id')
                ->join('vocab.variant_vocab as v', 'a.variant_id', '=', 'v.id')
                ->where('i.guid', $imageId)
                ->get();
    }
    
    public function getFeatures($imageId)
    {
        return DB::table('images.image_features as f')
                ->join('vocab.feature_vocab as v', 'f.feature_id', '=', 'v.id')
                ->select('v.uri', 'v.name', 'v.label')
                ->where('f.image_id', $imageId)
                ->get();
    }
    
    protected function imageQuery()
    {
        return DB::table('images.images as i')
                ->select('i.id', 'i.guid as image_id', 't.guid as taxon_id', 
                        'n.full_name as scientific_name', 
                        'at.guid as accepted_name_usage_id',
                        'an.full_name as accepted_name_usage', 
                        'v_st.name as subtype', 'v_sc.name as subject_category', 
                        'a.name as creator', 'v_l.uri as license', 'i.title', 
                        'i.source', 'i.caption', 'i.subject_part', 
                        'i.subject_orientation', 'i.create_date', 
                        'i.digitization_date', 'i.rights', 'i.rating', 
                        'i.is_hero_image', 'o.guid as occurrence_id')
                ->join('images.identifications as id', 
                        'i.id', '=', 'id.image_id')
                ->join('flora.taxa as t', 'id.taxon_id', '=', 't.id')
                ->join('flora.names as n', 't.name_id', '=', 'n.id')
                ->join('flora.taxa as at', 
                        't.accepted_id', '=', 'at.id')
                ->join('flora.names as an', 
                        'at.name_id', '=', 'an.id')
                ->join('vocab.subtype_vocab as v_st', 
                        'i.subtype_id', '=', 'v_st.id')
                ->leftJoin('vocab.subject_category_vocab as v_sc',
                        'i.subject_category_id', '=', 'v_sc.id')
                ->leftJoin('vocab.license_vocab as v_l', 
                        'i.license_id', '=', 'v_l.id')
                ->leftJoin('public.agents as a', 'i.creator_id', '=', 'a.id')
                ->leftJoin('images.occurrences as o', 'i.occurrence_id', '=', 'o.id')
                ->groupBy('i.id', 't.id', 'n.id', 'at.id', 'an.id', 'v_st.id',
                        'v_sc.id', 'v_l.id', 'a.id', 'o.id');
    }
    
    protected function pagination($query, $paginate=true, $pageSize=20)
    {
        if ($paginate) {
            return $query->paginate($pageSize)
                    ->withPath(env('APP_URL') . '/' . request()->path());
        }
        else {
            return $query->get();
        }
    }
    
    protected function higherTaxonSearch($query, $name, $rank=false)
    {
        $nodeNumber = 0;
        $highestDescendantNodeNumber = 0;
        $node = DB::table('flora.taxa as t')
                ->select('tt.node_number', 'tt.highest_descendant_node_number')
                ->join('flora.names as n', 't.scientific_name_id', '=', 'n.id')
                ->join('flora.taxon_tree_def_items as td', 
                        't.taxon_tree_def_item_id', '=', 'td.id')
                ->join('flora.taxon_tree as tt', 't.id', '=', 'tt.taxon_id')
                ->when($rank, function($node) use ($rank) {
                    return $node->where('td.name', $rank);   
                })
                ->where('n.full_name', $name)
                ->first();
        if ($node) {
            $nodeNumber = $node->node_number;
            $highestDescendantNodeNumber = 
                    $node->highest_descendant_node_number;
        }
        
        return $query->join('flora.taxon_tree as tt', 'at.id', '=', 
                        'tt.taxon_id')
                ->where('tt.node_number', '>=', $nodeNumber)
                ->where('tt.node_number', '<=', $highestDescendantNodeNumber);
    }
    
    protected function featureSearch($query, $features)
    {
        $nodes = DB::table('vocab.feature_vocab')
                ->select('node_number', 'highest_descendant_node_number')
                ->whereIn('name', explode(',', $features))
                ->get();
        $query->when($nodes, function($query) use ($nodes) {
            return $query->leftJoin('images.image_features as f', 
                    'i.id', '=', 'f.image_id')
                    ->leftJoin('vocab.feature_vocab as v_f', 
                            'f.feature_id', '=', 'v_f.id')
                    ->where(function($query) use ($nodes) {
                        return $query->orwhere(function($query) use ($nodes) {
                            foreach ($nodes as $node){
                                $query->where('v_f.node_number', '>=', 
                                        $nodes[0]->node_number)
                                    ->where('v_f.node_number', '<=', 
                                            $nodes[0]
                                            ->highest_descendant_node_number);
                            }
                        });
                    });
        }, function($query) {
            return $query->leftJoin('images.image_features as f', 
                    'i.id', '=', 'f.image_id');
        });
    }
    
    protected function sort($query, $sort)
    {
        $sorts = [
            'scientificName' => 'accepted_name_usage',
            'subtype' => 'subtype',
            'rating' => 'rating',
            'license' => 'license',
            'subject_category' => 'subject_category',
            'creator' => 'creator',
            'createDate' => 'create_date',
            'digitizationDate' => 'digitization_date'
        ];
        $params = explode(',', $sort);
        foreach ($params as $param) {
            echo $param . "\n";
            $dir = 'asc';
            if (substr($param, 0, 1) == '-') {
                $param = substr($param, 1);
                $dir = 'desc';
            }
            if (isset($sorts[$param])) {
                $query->orderBy($sorts[$param], $dir);
            }
        }
        return $query;
    }
            
}
