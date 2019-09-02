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
 *   definition="Treatment",
 *   type="object",
 *   required={"id", "treatment", "isCurrent"}
 * )
 */
class TreatmentTransformer extends Fractal\TransformerAbstract {
    
    protected $availableIncludes = [
        'forTaxon',
        
    ];
    
    protected $defaultIncludes = [
        'asTaxon',
        'acceptedNameUsage',
        'source',
        'creator',
        'modifiedBy'
    ];
    
    /**
     * @SWG\Property(
     *   property="id",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="treatment",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="isCurrent",
     *   type="boolean"
     * ),
     * 
     * @param type $treatment
     * @return type
     */
    public function transform($treatment)
    {
        $ret = [
            'id' => $treatment->guid . ':' . $treatment->version,
            'treatment' => $treatment->html,
            'isCurrent' => $treatment->is_current
        ];
        return $ret;
    }
    
    /**
     * @SWG\Property(
     *   property="forTaxon",
     *   ref="#/definitions/Taxon"
     * ),
     * 
     * @param object $treatment
     * @return \League\Fractal\Resource\Item
     */
    protected function includeForTaxon($treatment)
    {
        $taxonModel = new \VicFlora\Models\TaxonModel();
        $taxon = $taxonModel->getTaxon($treatment->taxon_guid);
        $transformer = new TaxonTransformer();
        return new Fractal\Resource\Item($taxon, $transformer, 'taxa');
    }
    
    /**
     * @SWG\Property(
     *   property="asTaxon",
     *   ref="#/definitions/Taxon"
     * ),
     * 
     * @param object $treatment
     * @return \League\Fractal\Resource\Item
     */
    protected function includeAsTaxon($treatment)
    {
        if ($treatment->as_guid) {
            $taxonModel = new \VicFlora\Models\TaxonModel();
            $taxon = $taxonModel->getTaxon($treatment->as_guid);
            $transformer = new TaxonTransformer();
            return new Fractal\Resource\Item($taxon, $transformer, 'taxa');
        }
    }
    
    /**
     * @SWG\Property(
     *   property="acceptedNameUsage",
     *   ref="#/definitions/Taxon"
     * ),
     * 
     * @param object $treatment
     * @return \League\Fractal\Resource\Item
     */
    protected function includeAcceptedNameUsage($treatment)
    {
        if ($treatment->accepted_guid) {
            $taxonModel = new \VicFlora\Models\TaxonModel();
            $taxon = $taxonModel->getTaxon($treatment->accepted_guid);
            $transformer = new TaxonTransformer();
            return new Fractal\Resource\Item($taxon, $transformer, 'taxa');
        }
    }
    
    /**
     * @SWG\Property(
     *   property="source",
     *   ref="#/definitions/Reference"
     * ),
     * 
     * @param object $treatment
     * @return \League\Fractal\Resource\Item
     */
    protected function includeSource($treatment)
    {
        if ($treatment->source_id) {
            $referenceModel = new \VicFlora\Models\ReferenceModel();
            $source = $referenceModel->getReference($treatment->source_id);
            $transformer = new ReferenceTransformer();
            return new Fractal\Resource\Item($source, $transformer, 'references');
        }
    }
    
    /**
     * @SWG\Property(
     *   property="creator",
     *   ref="#/definitions/Agent"
     * ),
     * 
     * @param object $treatment
     * @return \League\Fractal\Resource\Item
     */
    protected function includeCreator($treatment)
    {
        if (!$treatment->source_id) {
            $agent = (object) [
                'guid' => $treatment->created_by_agent_id,
                'agent_type' => $treatment->created_by_agent_type,
                'name' => $treatment->created_by_agent_name
            ];
            $transformer = new AgentTransformer();
            return new Fractal\Resource\Item($agent, $transformer, 'agents');
        }
    }
    
    /**
     * @SWG\Property(
     *   property="modifiedBy",
     *   ref="#/definitions/Agent"
     * ),
     * 
     * @param object $treatment
     * @return \League\Fractal\Resource\Item
     */
    protected function includeModifiedBy($treatment)
    {
        if ($treatment->is_updated) {
            $agent = (object) [
                'guid' => $treatment->created_by_agent_id,
                'agent_type' => $treatment->created_by_agent_type,
                'name' => $treatment->created_by_agent_name
            ];
            $transformer = new AgentTransformer();
            return new Fractal\Resource\Item($agent, $transformer, 'agents');
        }
    }
}
