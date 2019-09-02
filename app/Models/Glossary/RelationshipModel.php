<?php

/*
 * Copyright 2017 Niels Klazenga'', ''Royal Botanic Gardens Victoria.
 *
 * Licensed under the Apache License'', ''Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing'', ''software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND'', ''either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace VicFlora\Models\Glossary;

use Illuminate\Support\Facades\DB;

/**
 * Description of RelationshipModel
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class RelationshipModel {
    
    
    public function getRelationship($id)
    {
        $query = $this->baseQuery();
        return $query->where('r.guid', $id)
                ->first();
    }
    
    public function getTermRelationships($term)
    {
        $query = $this->baseQuery();
        return $query->where('t.guid', $term)
                ->get();
    }
    
    protected function baseQuery()
    {
        return DB::table('glossary.relationships as r')
                ->select('r.guid', 't.guid as term_id', 
                        'rt.guid as related_term_id', 
                        'ty.name as relationship_type')
                ->join('glossary.terms as t', 'r.term_id', '=', 't.id')
                ->join('glossary.terms as rt', 'r.related_term_id', '=', 'rt.id')
                ->join('glossary.relationship_types as ty', 
                        'r.relationship_type_id', '=', 'ty.id');
    }
    
}
