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
 * Description of FeatureTransformer
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class FeatureTransformer extends Fractal\TransformerAbstract {
    
    public function transform($feature) 
    {
        return [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [
                    $feature->decimal_longitude, 
                    $feature->decimal_latitude
                ],
            ],
            'properties' => [
                'crs' => [
                    'type' => 'name',
                    'properties' => [
                        'name' => 'urn:ogc:def:crs:EPSG::4326'
                    ]
                ],
                'occurrenceID' => $feature->uuid,
                'catalogNumber' => $feature->catalog_number,
                'dataSetName' => $feature->data_source,
                'taxonID' => $feature->taxon_id,
                'acceptedNameUsageID' => $feature->accepted_name_usage_id,
                'scientificName' => $feature->scientific_name,
                'occurrenceStatus' => $feature->occurrence_status,
                'establishmentMeans' => $feature->establishment_means
            ]
        ];
    }
    
}
