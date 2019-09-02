<?php

namespace VicFlora\Entities\Map;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="vicflora_taxa", schema="maps")
 */
class VicfloraTaxon {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer 
     */
    protected $id;
    
    /**
     * @ORM\Column(length=40, unique=true)
     * @var string
     */
    protected $scientificNameId;
    
    /**
     * @ORM\Column(length=40)
     * @var string
     */
    protected $acceptedNameUsageId;
    
    /**
     * @ORM\Column(length=40)
     * @var string
     */
    protected $speciesId;
    
    /**
     * @ORM\Column(length=128)
     * @var string
     */
    protected $scientificName;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $scientificNameAuthorship;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $taxonRank;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $acceptedNameUsage;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $acceptedNameUsageTaxonRank;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $kingdom;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $phylum;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $class;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $order;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $family;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $genus;
    
    /**
     * @ORM\Column(length=96, nullable=true)
     * @var string
     */
    protected $specificEpithet;
    
    /**
     * @ORM\Column(length=96, nullable=true)
     * @var string
     */
    protected $infraspecificEpithet;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $occurrenceStatus;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $establishmentMeans;
    
    /**
     * @ORM\Column(type="datetimetz")
     * @var datetime
     */
    protected $timestampCreated;
}