<?php

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="images")
 */
class Image extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Occurrence")
     * @ORM\JoinColumn(name="occurrence_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Imge\Occurrence
     */
    protected $occurrence;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $source;
    
    /**
     * @ORM\Column(type="string", name="dc_type", length=64)
     * @var string
     */
    protected $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subtype")
     * @ORM\JoinColumn(name="subtype_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Image\Subtype
     */
    protected $subtype;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $caption;
    
    /**
     * @ORM\ManyToOne(targetEntity="SubjectCategory")
     * @ORM\JoinColumn(name="subject_category_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Image\SubjectCategory
     */
    protected $subjectCategory;
    
    /**
     * @ORM\Column(type="string", name="subject_part", length=64, nullable=true)
     * @var string
     */
    protected $subjectPart;
    
    /**
     * @ORM\Column(type="string", name="subject_orientation", nullable=true)
     * @var string
     */
    protected $subjectOrientation;
    
    /**
     * @ORM\Column(type="date", name="create_date", nullable=true)
     * @var date
     */
    protected $createDate;
    
    /**
     * @ORM\Column(type="date", name="digitization_date", nullable=true)
     * @var string
     */
    protected $digitizationDate;
    
    /**
     * @ORM\ManyToOne(targetEntity="\VicFlora\Entities\Agent")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Agent
     */
    protected $creator;
    
    /**
     * @ORM\ManyToOne(targetEntity="\VicFlora\Entities\Agent")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id", nullable=false)
     * @var \VicFlora\Entities\Agent
     */
    protected $rightsHolder;
    
    /**
     * @ORM\ManyToOne(targetEntity="License")
     * @ORM\JoinColumn(name="license_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Image\License
     */
    protected $license;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $rights;
    
    /**
     * @ORM\Column(type="boolean", name="is_hero_image", nullable=true)
     * @var bool
     */
    protected $isHeroImage;
    
    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @var int
     */
    protected $rating;
}
