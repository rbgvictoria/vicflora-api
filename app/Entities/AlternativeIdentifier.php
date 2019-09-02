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

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alternative Identifiers
 * 
 * http://rs.gbif.org/extension/gbif/1.0/identifier.xml
 *
 * @author Niels Klazenga <Niels.Klazenga@rbg.vic.gov.au>
 * 
 * @ORM\Entity()
 * @ORM\Table(schema="flora", indexes={
 *     @ORM\Index(columns={"identifier"}),
 *     @ORM\Index(columns={"title"}),
 *     @ORM\Index(columns={"dataset_id"}),
 * })
 */
class AlternativeIdentifier extends ClassBase {
    
    /**
     * @ORM\Column()
     * @var string
     */
    protected $identifier;
    
    /**
     * @ORM\Column()
     * @var string 
     */
    protected $title;
    
    /**
     * @ORM\Column(length=32)
     * @var string
     */
    protected $datasetId;
    
    
}
