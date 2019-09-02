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
 * Description of DistributionModel
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class DistributionModel {
    
    public function getBioregionsForTaxon($taxonId, $rank=false)
    {
        $query = DB::connection('pgsql2');
        if ($rank == 'species') {
            $query = $query->table('vicflora.distribution_bioregion_species_view');
        }
        else {
            $query = $query->table('vicflora.distribution_bioregion_view');
        }
        
        $query = $query->select('taxon_id', DB::raw("'IBRA7' as source"), 
                        'sub_code_7 as area_code', 'sub_name_7 as area_name', 
                        'occurrence_status', 'establishment_means')
                ->groupBy('taxon_id', 'sub_code_7', 'sub_name_7', 'occurrence_status',
                        'establishment_means', 'depi_order')
                ->orderBy('depi_order')
                ->where('taxon_id', $taxonId)
                ->get();
        return $query;
    }
    
    public function getStateDistributionForTaxon($taxonId, $rank=false)
    {
        return DB::connection('pgsql2')
                ->table('vicflora.vicflora_statedistribution as d')
                ->join('vicflora.australia_states as s', 
                        'd.state_province', '=', 's.state')
                ->select(DB::raw("'$taxonId' as taxon_id"), 
                        DB::raw("'ISO' as source"),
                        's.iso as area_code', 
                        'd.state_province as area_name',
                        DB::raw("'present' as occurrence_status"),
                        DB::raw("NULL as establishment_means"))
                ->when($rank == 'species', function($query) use ($taxonId) {
                    $query->where('d.species_guid', $taxonId);
                }, function($query) use($taxonId) {
                    $query->where('d.taxon_id', $taxonId);
                })
                ->groupBy('s.iso', 
                        'd.state_province', 's.state_order')
                ->orderBy('s.state_order')
                ->get();
    }
}

/*
INSERT INTO vicflora.occurrence_attribute (uuid, reg_code_7, reg_name_7, sub_code_7, sub_name_7, nrm_region)
SELECT o.uuid, b.reg_code_7, b.reg_name_7, b.sub_code_7, b.sub_name_7, n.nrm_region
FROM vicflora.avh_occurrence o
JOIN vicflora.vicflora_bioregion b ON ST_Intersects(o.geom, b.geom)
JOIN vicflora.vicflora_nrm2014 n ON ST_Intersects(o.geom, n.geom)
LEFT JOIN vicflora.occurrence_attribute a ON o.uuid=a.uuid
WHERE a.uuid IS NULL AND o.vicflora_scientific_name_id='6aab544e-0f60-4287-bb6e-54ba18b64456'; 

 */
