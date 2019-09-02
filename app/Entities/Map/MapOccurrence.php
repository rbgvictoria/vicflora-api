<?php

namespace VicFlora\Entities\Map;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="maps", indexes={
 *     @ORM\Index(columns={"geom"}, flags={"spatial"})
 * })
 */
class MapOccurrence {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer 
     */
    protected $id;
    
    /**
     * @ORM\Column(length=128, unique=true)
     * @var string
     */
    protected $uuid;
    
    /**
     * @ORM\Column(length=128)
     * @var string
     */
    protected $scientificName;
    
    /**
     * @ORM\Column()
     * @var string
     */
    protected $unprocessedScientificName;
    
    /**
     * @ORM\ManyToOne(targetEntity="ParsedName")
     * @ORM\JoinColumn(name="parsed_name_id", referencedColumnName="id")
     * @var string
     */
    protected $parsedName;
    
    /**
     * @ORM\ManyToOne(targetEntity="VicfloraTaxon")
     * @ORM\JoinColumn(name="vicflora_scientific_name_id", 
     *     referencedColumnName="scientific_name_id")
     * @var \VicFlora\Entities\Map\VicfloraTaxon
     */
    protected $vicfloraScientificName;
    
    /**
     * @ORM\Column(type="decimal", precision=13, scale=10)
     * @var string
     */
    protected $decimalLongitude;
    
    /**
     * @ORM\Column(type="decimal", precision=13, scale=10)
     * @var string
     */
    protected $decimalLatitude;
    
    /**
     * @ORM\Column(type="geometry", options={"geometry_type"="POINT", "srid"=4326})
     * @var string
     */
    protected $geom;
    
    /**
     * @ORM\Column(length=8)
     * @var string
     */
    protected $dataSource;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $sensitive;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $establismentMeans;
    
    /**
     * @ORM\Column(type="datetimetz")
     * @var datetime
     */
    protected $timestampCreated;
    
    /**
     * @ORM\Column(type="datetimetz", nullable=false)
     * @var datetime
     */
    protected $timestampModified;
}