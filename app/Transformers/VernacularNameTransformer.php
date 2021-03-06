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
 * Description of VernacularNameTransformer
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 * 
 * @SWG\Definition(
 *   definition="VernacularName",
 *   type="object",
 *   required={"id", "vernacularName"}
 * )
 */
class VernacularNameTransformer extends Fractal\TransformerAbstract {
    
    protected $defaultIncludes = [];
    
    protected $availableIncludes = [
        'taxon'
    ];
    
    /**
     * @SWG\Property(
     *     property="id",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="vernacularName",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="vernacularNameUsage",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="isPreferredName",
     *     type="string"
     * ),
     * 
     * @param object $vernacularName
     * @return array
     */
    public function transform($vernacularName)
    {
        return [
            'id' => $vernacularName->guid,
            'vernacularName' => $vernacularName->vernacular_name,
            'vernacularNameUsage' => $vernacularName->vernacular_name_usage,
            'isPreferredName' => $vernacularName->is_preferred_name,
        ];
    }
    
    /**
     * @SWG\Property(
     *     property="taxon",
     *     ref="#/definitions/Taxon"
     * )
     * 
     * @param object $vernacularName
     * @return \League\Fractal\Resource\Item
     */
    protected function includeTaxon($vernacularName)
    {
        $taxonModel = new \VicFlora\Models\TaxonModel();
        $taxon = $taxonModel->getTaxon($vernacularName->taxon_id);
        $transformer = new TaxonTransformer();
        return new Fractal\Resource\Item($taxon, $transformer, 'taxa');
    }
}
