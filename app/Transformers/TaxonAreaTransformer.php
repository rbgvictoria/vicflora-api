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

namespace VicFlora\Transformers;

use League\Fractal;

/**
 * Description of ReferenceTransformer
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 * 
 * @SWG\Definition(
 *   definition="TaxonArea",
 *   type="object",
 *   required={"id", "locationID", "source", "countryCode", "locality", "occurrenceStatus"}
 * )
 */
class TaxonAreaTransformer extends Fractal\TransformerAbstract {
    
    protected $availableIncludes = [];
    
    protected $defaultIncludes = [];
    
    /**
     * @SWG\Property(
     *     property="id",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="locationID",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="source",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="countryCode",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="locality",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="occurrenceStatus",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="establishmentMeans",
     *     type="string"
     * ),
     * 
     * @param object $area
     * @return array
     */
    public function transform($area)
    {
        return [
            'id' => $area->taxon_id . ':' . $area->source . ':' . $area->area_code,
            'locationID' => $area->source . ':' . $area->area_code,
            'source' => $area->source,
            'countryCode' => 'AU',
            'locality' => $area->area_name,
            'occurrenceStatus' => $area->occurrence_status ?: 'present',
            'establishmentMeans' => $area->establishment_means,
        ];
    }
    
}
