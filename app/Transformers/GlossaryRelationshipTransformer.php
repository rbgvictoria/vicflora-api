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
 * Description of GlossaryRelationshipTransformer
 *
 * @SWG\Definition(
 *   definition="GlossaryRelationship",
 *   type="object",
 *   required={"id"}
 * )
 * 
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 */
class GlossaryRelationshipTransformer extends Fractal\TransformerAbstract {
    
    protected $defaultIncludes = [
        'relatedTerm'
    ];
    
    protected $availableIncludes = [
        'term'
    ];
    
    /**
     * @SWG\Property(
     *     property="id",
     *     type="string"
     * ),
     * @SWG\Property(
     *     property="relationshipType",
     *     type="string"
     * ),
     * 
     * @param type $relationship
     * @return type
     */
    public function transform($relationship)
    {
        return [
            'id' => $relationship->guid,
            'relationshipType' => $relationship->relationship_type
        ];
    }
    
    /**
     * @SWG\Property(
     *     property="term",
     *     ref="#/definitions/GlossaryTerm"
     * ),
     * 
     * @param object $relationship
     * @return \League\Fractal\Resource\Item
     */
    protected function includeTerm($relationship)
    {
        $termModel = new \VicFlora\Models\Glossary\TermModel();
        $term = $termModel->getTerm($relationship->term_id);
        $transformer = new GlossaryTermTransformer();
        return new Fractal\Resource\Item($term, $transformer, 'glossary/terms');
    }
    
    /**
     * @SWG\Property(
     *     property="relatedTerm",
     *     ref="#/definitions/GlossaryTerm"
     * ),
     * 
     * @param object $relationship
     * @return \League\Fractal\Resource\Item
     */
    protected function includeRelatedTerm($relationship)
    {
        $termModel = new \VicFlora\Models\Glossary\TermModel();
        $term = $termModel->getTerm($relationship->related_term_id);
        $transformer = new GlossaryTermTransformer();
        return new Fractal\Resource\Item($term, $transformer, 'glossary/terms');
    }
}
