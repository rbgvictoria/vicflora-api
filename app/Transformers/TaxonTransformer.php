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
 *   definition="Taxon",
 *   type="object",
 *   required={"id", "taxonRank", "scientificName"}
 * )
 */
class TaxonTransformer extends Fractal\TransformerAbstract {
    
    protected $availableIncludes = [
        'parentNameUsage',
        'classification',
        'siblings',
        'children',
        'synonyms',
        'treatments',
        'changes',
        'bioregionDistribution',
        'stateDistribution',
        'creator',
        'modifiedBy',
        'heroImage',
        'vernacularNames'
    ];
    
    protected $defaultIncludes = [
        'name',
        'acceptedNameUsage',
        'nameAccordingTo',
    ];
    
    
    /**
     * @SWG\Property(
     *   property="id",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="taxonRank",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="taxonomicStatus",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="occurrenceStatus",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="isEndemic",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="establishmentMeans",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="threatStatus",
     *   type="string"
     * ),
     * @SWG\Property(
     *   property="taxonRemarks",
     *   type="string"
     * )
     * 
     * @param object $taxon
     * @return array
     */
    public function transform($taxon)
    {
        $ret = [
            'id' => $taxon->guid,
            'taxonRank' => $taxon->rank,
            'taxonomicStatus' => $taxon->taxonomic_status,
        ];
        if (isset($taxon->occurrence_status)) {
            $ret['occurrenceStatus'] = $taxon->occurrence_status;
        }
        if (isset($taxon->is_endemic)) {
            $ret['isEndemic'] = $taxon->is_endemic;
        }
        if (isset($taxon->establishment_means)) {
            $ret['establishmentMeans'] = $taxon->establishment_means;
        }
        if (isset($taxon->threat_status)) {
            $ret['threatStatus'] = $taxon->threat_status;
        }
        if (isset($taxon->taxon_remarks)) {
            $ret['taxonRemarks'] = $taxon->taxon_remarks;
        }
        return $ret;
    }
    
    /**
     * @SWG\Property(
     *   property="creator",
     *   ref="#/definitions/Agent"
     * )
     * 
     * @param object $taxon
     * @return \League\Fractal\Resource\Item
     */
    public function includeCreator($taxon)
    {
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($taxon->creator);
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
    * @param object $taxon
    * @return \League\Fractal\Resource\Item
    */
    public function includeModifiedBy($taxon)
    {
        $agentModel = new \VicFlora\Models\AgentModel();
        $agent = $agentModel->getAgent($taxon->modified_by);
        if ($agent) {
            $transformer = new \VicFlora\Transformers\AgentTransformer();
            return new Fractal\Resource\Item($agent, $transformer, 'agents');
        }
    }
    
    /**
    * @SWG\Property(
    *   property="name",
    *   ref="#/definitions/Name"
    * )
    * 
    * @param object $taxon
    * @return \League\Fractal\Resource\Item
    */
    public function includeName($taxon)
    {
        if (isset($taxon->scientific_name_id)) {
            $nameModel = new \VicFlora\Models\NameModel();
            $name = $nameModel->getName($taxon->scientific_name_id);
            if ($name) {
                $transformer = new \VicFlora\Transformers\NameTransformer();
                return new Fractal\Resource\Item($name, $transformer, 'names');
            }
        }
    }
    
    /**
    * @SWG\Property(
    *   property="acceptedNameUsage",
    *   ref="#/definitions/Name"
    * )
     * 
     * @param object $taxon
     * @return \League\Fractal\Resource\Item
     */
    public function includeAcceptedNameUsage($taxon)
    {
        if (isset($taxon->accepted_name_usage_id) 
                && $taxon->accepted_name_usage_id 
                && $taxon->taxonomic_status != 'accepted') {
            $taxonModel = new \VicFlora\Models\TaxonModel();
            $tax = $taxonModel->getTaxon($taxon->accepted_name_usage_id);
            if ($tax) {
                $transformer = new \VicFlora\Transformers\TaxonTransformer();
                return new Fractal\Resource\Item($tax, $transformer, 'taxa');
            }
        }
    }
    
    /**
    * @SWG\Property(
    *   property="parentNameUsage",
    *   ref="#/definitions/Name"
    * )
     * 
     * @param object $taxon
     * @return \League\Fractal\Resource\Item
     */
    public function includeParentNameUsage($taxon)
    {
        $taxonModel = new \VicFlora\Models\TaxonModel();
        $tax = $taxonModel->getTaxon($taxon->parent_name_usage_id);
        if ($tax) {
            $transformer = new \VicFlora\Transformers\TaxonTransformer();
            return new Fractal\Resource\Item($tax, $transformer, 'taxa');
        }
    }
    
    /**
    * @SWG\Property(
    *   property="nameAccordingTo",
    *   ref="#/definitions/Reference"
    * )
     * 
     * @param object $taxon
     * @return \League\Fractal\Resource\Item
     */
    public function includeNameAccordingTo($taxon)
    {
        if (isset($taxon->name_according_to_id) && $taxon->name_according_to_id) {
            $referenceModel = new \VicFlora\Models\ReferenceModel();
            $nameAccordingTo = $referenceModel->getReference($taxon->name_according_to_id);
            if ($nameAccordingTo) {
                $transformer = new ReferenceTransformer();
                return new Fractal\Resource\Item($nameAccordingTo, $transformer, 'references');
            }
        }
    }
    
    /**
    * @SWG\Property(
    *   property="classification",
    *   @SWG\Schema(
    *       type="array",
    *       @SWG\Items(
    *           ref="#/definitions/Taxon"
    *       )
     *  )
    * )
    * 
    * @param object $taxon
    * @return \League\Fractal\Resource\Collection
    */
    public function includeClassification($taxon)
    {
        $taxonModel = new \VicFlora\Models\TaxonModel();
        $taxa = $taxonModel->getHigherClassification($taxon->guid);
        if ($taxa) {
            $transformer = new TaxonTransformer();
            return new Fractal\Resource\Collection($taxa, $transformer, 'taxa');
        }
    }
    
    /**
    * @SWG\Property(
    *   property="siblings",
    *   type="array",
    *   items=@SWG\Schema(
    *       ref="#/definitions/Taxon"
    *   )
    * )
    * 
    * @param object $taxon
    * @return \League\Fractal\Resource\Collection
    */
    public function includeSiblings($taxon)
    {
        $taxonModel = new \VicFlora\Models\TaxonModel();
        $taxa = $taxonModel->getSiblings($taxon->guid);
        if ($taxa) {
            $transformer = new TaxonTransformer();
            return new Fractal\Resource\Collection($taxa, $transformer, 'taxa');
        }
    }
    
    /**
    * @SWG\Property(
    *   property="children",
    *   type="array",
    *   items=@SWG\Schema(
    *       ref="#/definitions/Taxon"
    *   )
    * )
    * 
    * @param object $taxon
    * @return \League\Fractal\Resource\Collection
    */
    public function includeChildren($taxon)
    {
        $taxonModel = new \VicFlora\Models\TaxonModel();
        $taxa = $taxonModel->getChildren($taxon->guid);
        if ($taxa) {
            $transformer = new TaxonTransformer();
            return new Fractal\Resource\Collection($taxa, $transformer, 'taxa');
        }
    }
    
    /**
    * @SWG\Property(
    *   property="synonyms",
    *   type="array",
    *   items=@SWG\Schema(
    *       ref="#/definitions/Taxon"
    *   )
    * )
    * 
    * @param object $taxon
    * @return \League\Fractal\Resource\Collection
    */
    public function includeSynonyms($taxon)
    {
        $taxonModel = new \VicFlora\Models\TaxonModel();
        $taxa = $taxonModel->getSynonyms($taxon->guid);
        if ($taxa) {
            $transformer = new TaxonTransformer();
            return new Fractal\Resource\Collection($taxa, $transformer, 'taxa');
        }
    }
    
    /**
     * @SWG\Property(
     *   property="treatments",
     *   type="array",
     *   items=@SWG\Schema(
     *       ref="#/definitions/Treatment"
     *   )
     * )
     * 
     * @param object $taxon
     * @return \League\Fractal\Resource\Collection
     */
    protected function includeTreatments($taxon)
    {
        $params = ['filter' => ['taxonID' => $taxon->guid]];
        $treatmentModel = new \VicFlora\Models\TreatmentModel();
        $treatments = $treatmentModel->getTreatments($params, false);
        $transformer = new \VicFlora\Transformers\TreatmentTransformer();
        return new Fractal\Resource\Collection($treatments, $transformer, 
                'treatments');
    }
    
    
    /**
     * @SWG\Property(
     *   property="changes",
     *   type="array",
     *   items=@SWG\Schema(
     *       ref="#/definitions/Change"
     *   )
     * )
     * 
     * @param object $taxon
     * @return \League\Fractal\Resource\Collection
     */
    public function includeChanges($taxon)
    {
        $changeModel = new \VicFlora\Models\ChangeModel();
        $params = ['filter' => ['fromTaxonID' => $taxon->guid]];
        $changes = $changeModel->getChanges($params, false);
        if ($changes) {
            $transformer = new ChangeTransformer();
            return new Fractal\Resource\Collection($changes, $transformer, 
                    'changes');
        }
    }
    
    /**
     * @SWG\Property(
     *   property="bioregionDistribution",
     *   type="array",
     *   items=@SWG\Schema(
     *       ref="#/definitions/TaxonArea"
     *   )
     * )
     * 
     * @param object $taxon
     * @return \League\Fractal\Resource\Collection
     */
    public function includeBioregionDistribution($taxon)
    {
        if ($taxon->taxonomic_status == 'accepted' &&
                in_array($taxon->rank, ['species', 'subspecies', 'variety', 
                    'subvariety', 'forma', 'subforma', 'nothosubspecies', 
                    'nothovariety'])) {
            $distributionModel = new \VicFlora\Models\DistributionModel();
            $distribution = $distributionModel->getBioregionsForTaxon(
                    $taxon->guid, $taxon->rank);
            $transformer = new TaxonAreaTransformer();
            return new Fractal\Resource\Collection($distribution, $transformer, 
                    'areas');
        }
    }
    
    /**
     * @SWG\Property(
     *   property="stateDistribution",
     *   type="array",
     *   items=@SWG\Schema(
     *       ref="#/definitions/TaxonArea"
     *   )
     * )
     * 
     * @param object $taxon
     * @return \League\Fractal\Resource\Collection
     */
    public function includeStateDistribution($taxon)
    {
        if ($taxon->taxonomic_status == 'accepted' &&
                in_array($taxon->rank, ['species', 'subspecies', 'variety', 
                    'subvariety', 'forma', 'subforma', 'nothosubspecies', 
                    'nothovariety'])) {
            $distributionModel = new \VicFlora\Models\DistributionModel();
            $distribution = $distributionModel->getStateDistributionForTaxon(
                    $taxon->guid, $taxon->rank);
            $transformer = new TaxonAreaTransformer();
            return new Fractal\Resource\Collection($distribution, $transformer, 
                    'areas');
        }
    }
    
    /**
     * @SWG\Property(
     *     property="heroImage",
     *     ref="#/definitions/Image"
     * )
     * 
     * @param type $taxon
     * @return \League\Fractal\Resource\Item
     */
    public function includeHeroImage($taxon)
    {
        if ($taxon->taxonomic_status == 'accepted' &&
                in_array($taxon->rank, ['family', 'genus', 'species', 
                    'subspecies', 'variety', 
                    'subvariety', 'forma', 'subforma', 'nothosubspecies', 
                    'nothovariety'])) {
            $imageModel = new \VicFlora\Models\ImageModel();
            $heroImage = $imageModel->getHeroImage($taxon->guid);
            if ($heroImage) {
                $transformer = new ImageTransformer();
                $transformer->setDefaultIncludes(['accessPoints']);
                return new Fractal\Resource\Item($heroImage, $transformer, 'images');
            }
        }
    }
    
    /**
     * @SWG\Property(
     *   property="vernacularNames",
     *   type="array",
     *   items=@SWG\Schema(
     *       ref="#/definitions/VernacularName"
     *   )
     * )
     * 
     * @param object $taxon
     * @return \League\Fractal\Resource\Collection
     */
    public function includeVernacularNames($taxon)
    {
        $vernacularNameModel = new \VicFlora\Models\VernacularNameModel();
        $names = $vernacularNameModel->getVernacularNames($taxon->guid);
        if ($names) {
            $transformer = new VernacularNameTransformer();
            return new Fractal\Resource\Collection($names, $transformer, 
                    'vernacular-names');
        }
    }
}
