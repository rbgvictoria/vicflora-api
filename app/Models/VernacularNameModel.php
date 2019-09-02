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
 * VernacularNameModel
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class VernacularNameModel 
{
    
    public function getVernacularNames($taxonId=false) {
        return DB::table('flora.vernacular_names as v')
                ->join('flora.taxa as t', 'v.taxon_id', '=', 't.id')
                ->select('v.guid', 't.guid as taxon_id', 'v.vernacular_name',
                        'v.vernacular_name_usage', 'v.is_preferred_name')
                ->when($taxonId, function($query) use ($taxonId) {
                    return $query->where('t.guid', $taxonId);
                })
                ->get();
    }
    
    public function getVernacularName($id)
    {
        return DB::table('flora.vernacular_names as v')
                ->join('flora.taxa as t', 'v.taxon_id', '=', 't.id')
                ->select('v.guid', 't.guid as taxon_id', 'v.vernacular_name',
                        'v.vernacular_name_usage', 'v.is_preferred_name')
                ->where('v.guid', $id)
                ->first();
    }
}
