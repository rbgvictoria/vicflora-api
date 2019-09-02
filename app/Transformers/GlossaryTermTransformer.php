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
 * Description of GlossaryTermTransformer
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 * 
 * @SWG\Definition(
 *   definition="GlossaryTerm",
 *   type="object",
 *   required={"id"}
 * )
 */
class GlossaryTermTransformer extends Fractal\TransformerAbstract {
    
    protected $defaultIncludes = [];
    
    protected $availableIncludes = [
        'relationships',
        'creator',
        'modifiedBy'
    ];
    
    /**
     * @SWG\Property(
     *     property="id",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="name",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="definition",
     *     type="string"
     * ),
     * 
     * @param object $term
     * @return array
     */
    public function transform($term) 
    {
        return [
            'id' => $term->guid,
            'name' => $term->name,
            'definition' => $term->definition
        ];
    }
    
    /**
     * @SWG\Property(
     *     property="relationships",
     *     type="array",
     *     @SWG\Items(
     *         ref="#/definitions/GlossaryRelationship"
     *     )
     * ),
     * 
     * @param object $term
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRelationships($term)
    {
        $relModel = new \VicFlora\Models\Glossary\RelationshipModel();
        $rels = $relModel->getTermRelationships($term->guid);
        if (count($rels)) {
            $transformer = new GlossaryRelationshipTransformer();
            return new Fractal\Resource\Collection($rels, $transformer, 
                    'glossary/relationships');
        }
    }
    
    /**
     * @SWG\Property(
     *     property="creator",
     *     ref="#/definitions/Agent"
     * ),
     * 
     * @param object $term
     * @return \League\Fractal\Resource\Item
     */
    public function includeCreator($term)
    {
        if ($term->creator) {
            $agentModel = new \VicFlora\Models\AgentModel();
            $agent = $agentModel->getAgent($term->creator);
            $transformer = new AgentTransformer();
            return new Fractal\Resource\Item($agent, $transformer, 'agents');
        }
    }
    
    /**
     * @SWG\Property(
     *     property="modifiedBy",
     *     ref="#/definitions/Agent"
     * ),
     * 
     * @param object $term
     * @return \League\Fractal\Resource\Item
     */
    public function includeModifiedBy($term)
    {
        if ($term->modified_by) {
            $agentModel = new \VicFlora\Models\AgentModel();
            $agent = $agentModel->getAgent($term->modified_by);
            $transformer = new AgentTransformer();
            return new Fractal\Resource\Item($agent, $transformer, 'agents');
        }
    }
}
