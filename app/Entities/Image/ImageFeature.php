<?php

/* 
 * Copyright 2017 Royal Botanic Gardens Victoria.
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

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="images")
 */
class ImageFeature extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=false)
     * @var \VicFlora\Entities\Image\Image
     */
    protected $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="Feature")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id", nullable=false)
     * @var \VicFlora\Entities\Image\Feature
     */
    protected $feature;
}

