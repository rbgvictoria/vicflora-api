<?php

namespace VicFlora\Entities\Map;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="maps", indexes={
 *     @ORM\Index(columns={"scientific_name"})
 * })
 */
class ParsedName {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer 
     */
    protected $id;
    
    /**
     * @ORM\Column()
     * @var string
     */
    protected $scientificName;
    
    /**
     * @ORM\Column(length=32)
     * @var string
     */
    protected $type;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $authorsParsed;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $genusOrAbove;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $specificEpithet;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $infraspecificEpithet;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $cultivarEpithet;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $strain;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $notho;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $rankMarker;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $authorship;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $bracketAuthorship;
    
    /**
     * @ORM\Column(length=16, nullable=true)
     * @var string
     */
    protected $year;
    
    /**
     * @ORM\Column(length=16, nullable=true)
     * @var string
     */
    protected $bracketYear;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $sensu;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $nomStatus;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $canonicalName;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $canonicalNameWithMarker;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $canonicalNameComplete;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $infrageneric;
    
    /**
     * @ORM\ManyToOne(targetEntity="VicfloraTaxon")
     * @ORM\JoinColumn(name="vicflora_scientific_name_id", 
     *     referencedColumnName="scientific_name_id")
     * @var \VicFlora\Entities\Map\VicfloraTaxon 
     */
    protected $vicfloraScientificName;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $nameMatchType;
    
    /**
     * @ORM\Column(type="datetimetz")
     * @var datetime
     */
    protected $timestampCreated;
}