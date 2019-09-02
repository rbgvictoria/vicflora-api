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
 * Description of MapModel
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class FeatureModel {
    
    public function getFeaturesForTaxon($taxonId, $species=false, 
            $paginate=true, $pageSize=20)
    {
        $query = $this->baseQuery();
        return $query->when($species, function($query) use ($taxonId) {
                    return $query->where('o.taxon_id', $taxonId);
                }, function($query) use ($taxonId) {
                    return $query->where('o.species_id', $taxonId);
                })
                ->when($paginate, function($query) use ($pageSize) {
                    return $query->paginate($pageSize)
                            ->withPath('https://vicflora.rbg.vic.gov.au/' . 
                                    request()->path());
                }, function($query) {
                    return $query->get();
                });
    }
    
    protected function baseQuery()
    {
        return DB::connection('pgsql2')->table('vicflora.occurrence_view as o')
                ->select('o.uuid', 'o.decimal_longitude', 'o.decimal_latitude', 
                        'o.catalog_number', 'o.data_source', 'o.taxon_id', 
                        'o.accepted_name_usage_id', 'o.scientific_name', 
                        'o.occurrence_status', 'o.establishment_means');
    }
}
