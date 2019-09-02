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
 *   definition="Name",
 *   type="object",
 *   required={"id", "scientificName"}
 * )
 */
class NameTransformer extends Fractal\TransformerAbstract {
    
    protected $availableIncludes = [
        'namePublishedIn',
        'creator',
        'modifiedBy',
    ];
    
    protected $defaultIncludes = [
    ];
    
    /**
     * @SWG\Property(
     *   property="id",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="scientificName",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="scientificNameAuthorship",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="namePart",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="nomenclaturalNote",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="created",
     *   type="string",
     *   format="dateTime"
     * ),
     * @SWG\Property(
     *   property="modified",
     *   type="string",
     *   format="dateTime"
     * ),
     * 
     * @param object $name
     * @return array
     */
    public function transform($name)
    {
        return [
            'id' => $name->guid,
            'scientificName' => $name->full_name,
            'scientificNameAuthorship' => $name->authorship,
            'namePart' => $name->name,
            'nomenclaturalNote' => $name->nomenclatural_note,
            'created' => $name->timestamp_created,
            'modified' => $name->timestamp_modified
        ];
    }
    
    /**
     * @SWG\Property(
     *   property="creator",
     *   ref="#/definitions/Agent"
     * )
     * 
     * @param object $name
     * @return \League\Fractal\Resource\Item
     */
    public function includeCreator($name)
    {
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($name->creator);
        if ($agent) {
            $transformer = new \VicFlora\Transformers\AgentTransformer();
            return new Fractal\Resource\Item($agent, $transformer, 'agents');
        }
    }
    
    /**
     * @SWG\Property(
     *   property="modifiedBy",
     *   ref="#/definitions/Agent"
     * )
     * 
     * @param object $name
     * @return \League\Fractal\Resource\Item
     */
    public function includeModifiedBy($name)
    {
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($name->modified_by);
        if ($agent) {
            $transformer = new \VicFlora\Transformers\AgentTransformer();
            return new Fractal\Resource\Item($agent, $transformer, 'agents');
        }
    }
    
    /**
    /**
     * @SWG\Property(
     *   property="namePublishedIn",
     *   ref="#/definitions/Reference"
     * )
     * 
     * @param type object
     * @return \League\Fractal\Resource\Item
     */
    public function includeNamePublishedIn($name)
    {
        if ($name->name_published_in) {
            $referenceModel = new \VicFlora\Models\ReferenceModel();
            $publishedIn = $referenceModel->getReference($name->name_published_in);
            if ($publishedIn) {
                $transformer = new ReferenceTransformer();
                return new Fractal\Resource\Item($publishedIn, $transformer, 'references');
            }
        }
    }
}
