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

use Illuminate\Support\Facades\DB;

/**
 * Description of ReferenceModel
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class TaxonModel 
{
    public function getTaxon($id, $isInclude=false)
    {
        $query = $this->baseQuery();
        if ($isInclude) {
            $query = $this->baseQueryInclude();
        }
        return $query->where('t.guid', '=', $id)
                ->first();
    }
    
    public function getTaxonInclude($id)
    {
        $query = $this->baseQuery(true);
        return $query->where('t.guid', $id)
                ->first();
    }
    
    protected function baseQuery($isInclude=false)
    {
        return DB::table('flora.taxa as t')
                ->when($isInclude, function($query) {
                    return $query->select('t.guid', 'td.name as rank', 'n.full_name', 
                        'n.authorship', 'vts.name as taxonomic_status');
                    
                }, function($query) {
                    return $query->select('t.id', 'td.name as rank', 
                        'n.guid as scientific_name_id', 'n.full_name', 
                        'n.authorship',
                        'at.guid as accepted_name_usage_id', 
                        'pt.guid as parent_name_usage_id', 
                        'r.guid as name_according_to_id', 
                        'vts.name as taxonomic_status', 
                        'vos.name as occurrence_status', 't.is_endemic', 
                        'vem.name as establishment_means', 
                        'vth.name as threat_status', 't.taxon_remarks', 
                        'ca.guid as creator', 'ma.guid as modified_by', 
                        't.timestamp_created', 't.timestamp_modified', 
                        't.guid');
                })
                ->join('flora.names as n', 't.name_id', '=', 'n.id')
                ->join('flora.taxon_tree_def_items as td', 
                        't.taxon_tree_def_item_id', '=', 'td.id')
                ->leftJoin('flora.taxa as at', 
                        't.accepted_id', '=', 'at.id')
                ->leftJoin('flora.taxa as pt', 
                        't.parent_id', '=', 'pt.id')
                ->leftJoin('public.references as r', 
                        't.name_according_to_id', '=', 'r.id')
                ->leftJoin('vocab.taxonomic_status_vocab as vts', 
                        't.taxonomic_status_id', '=', 'vts.id')
                ->leftJoin('vocab.occurrence_status_vocab as vos', 
                        't.occurrence_status_id', '=', 'vos.id')
                ->leftJoin('vocab.establishment_means_vocab as vem', 
                        't.establishment_means_id', '=', 'vem.id')
                ->leftJoin('vocab.threat_status_vocab as vth', 
                        't.threat_status_id', '=', 'vth.id')
                ->leftJoin('public.agents as ca', 
                        't.created_by_id', '=', 'ca.id')
                ->leftJoin('public.agents as ma', 
                        't.modified_by_id', '=', 'ma.id');
    }
    
    public function getHigherClassification($id, $isInclude=false)
    {
        $ret = [];
        $nodeNumber = DB::table('flora.taxa as t')
                ->join('flora.taxon_tree as tr', 't.id', '=', 'tr.taxon_id')
                ->where('t.guid', '=', $id)
                ->value('tr.node_number');
        
        if ($nodeNumber) {
            $query = $this->baseQuery($isInclude);
            $ret = $query->join('flora.taxon_tree as tr', 't.id', '=', 'tr.taxon_id')
                    ->join('flora.taxon_tree_def_items as tdi',
                            't.taxon_tree_def_item_id', '=', 'tdi.id')
                    ->where('tr.node_number', '<', $nodeNumber)
                    ->where('tr.highest_descendant_node_number', '>=', $nodeNumber)
                    ->orderBy('tdi.rank_id')
                    ->get();
        }
        return $ret;
    }
    
    public function getChildren($id)
    {
        $query = $this->baseQuery($isInclude);
        return $query->where('pt.guid', '=', $id)
                ->where('vts.name', '=', 'accepted')
                ->orderBy('n.full_name')
                ->get();
    }
    
    public function getSiblings($id)
    {
        $parent = DB::table('flora.taxa')
                ->where('guid', $id)
                ->value('parent_id');
        
        $query = $this->baseQuery();
        return $query->where('pt.id', '=', $parent)
                ->where('vts.name', '=', 'accepted')
                ->orderBy('n.full_name')
                ->get();
    }
    
    public function getSynonyms($id)
    {
        $query = $this->baseQuery();
        return $query->where('at.guid', '=', $id)
                ->whereColumn('at.id', '!=', 't.id')
                ->orderBy('n.full_name')
                ->get();
    }
}
