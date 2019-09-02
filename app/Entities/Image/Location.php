<?php

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="images")
 */
class Location extends ClassBase {
    
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $country;
    
    /**
     * @ORM\Column(type="string", name="country_code", length=2, nullable=true)
     * @var string
     */
    protected $countryCode;
    
    /**
     * @ORM\Column(type="string", name="state_province", length=64, nullable=true)
     * @var string
     */
    protected $stateProvince;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $locality;
    
    /**
     * @ORM\Column(type="decimal", name="decimal_longitude", scale=10, 
     *     precision=13, nullable=true)
     * @var string
     */
    protected $decimalLongitude;
    
    /**
     * @ORM\Column(type="decimal", name="decimal_latitude", scale=10, 
     *     precision=13, nullable=true)
     * @var string
     */
    protected $decimalLatitude;
}
