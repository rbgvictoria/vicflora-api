<?php

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="images", indexes={
 *     @ORM\Index(columns={"is_current"})
 * })
 */
class Identification extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Occurrence")
     * @ORM\JoinColumn(name="occurrence_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Image\Occurrence
     */
    protected $occurrence;
    
    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Image\Image
     */
    protected $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="\VicFlora\Entities\Taxon")
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="id", 
     *   nullable=false)
     * @var \VicFlora\Entities\Taxon
     */
    protected $taxon;
    
    /**
     * @ORM\ManyToOne(targetEntity="\VicFlora\Entities\Agent")
     * @ORM\JoinColumn(name="identified_by_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Agent
     */
    protected $identifiedBy;
    
    /**
     * @ORM\Column(type="date", name="date_identified", nullable=true)
     * @var date;
     */
    protected $dateIdentified;
    
    /**
     * @ORM\Column(type="text", name="identification_remarks", nullable=true)
     * @var text
     */
    protected $identificationRemarks;
    
    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    protected $isCurrent;
}
