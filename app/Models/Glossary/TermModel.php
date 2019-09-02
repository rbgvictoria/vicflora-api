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

namespace VicFlora\Models\Glossary;

use Illuminate\Support\Facades\DB;

/**
 * Description of TermModel
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class TermModel {

    public function getTerms($params, $paginate=true, $pageSize=20)
    {
        $query = $this->baseQuery();
        if(isset($params['filter'])) {
            $query = $this->filter($query, $params['filter']);
        }
        return $this->pagination($query, $paginate, $pageSize);
    }
    
    public function getTerm($id)
    {
        $query = $this->baseQuery();
        return $query->where('t.guid', $id)->first();
    }
    
    protected function baseQuery()
    {
        return DB::table('glossary.terms as t')
                ->select('t.id', 't.guid', 't.name', 't.definition', 
                        't.timestamp_created', 't.timestamp_modified', 
                        'ca.guid as creator', 'ma.guid as modified_by')
                ->leftJoin('public.agents as ca', 't.created_by_id', '=', 'ca.id')
                ->leftJoin('public.agents as ma', 't.created_by_id', '=', 'ma.id')
                ->orderBy('name');
    }

    protected function pagination($query, $paginate=true, $pageSize=20)
    {
        if ($paginate) {
            return $query->paginate($pageSize)
                    ->withPath('https://vicflora.rbg.vic.gov.au/' . 
                            request()->path());
        }
        else {
            return $query->get();
        }
    }
    
    protected function filter($query, $filter)
    {
        $query->when(isset($filter['term']), function($query) use ($filter) {
            return $query->where('t.name', $filter['term']);
        });
        return $query;
    }
    
}
