<?php

namespace VicFlora\Entities\Map;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="maps", indexes={
 *     @ORM\Index(columns={"geom"}, flags={"spatial"})
 * })
 */
class Reserve {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer 
     */
    protected $gid;
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $type;
    
    /**
     * @ORM\Column(length=16)
     * @var string
     */
    protected $typeAbbr;
    
    /**
     * @ORM\Column(length=8)
     * @var string
     */
    protected $iucn;
    
    /**
     * @ORM\Column(length=4)
     * @var string
     */
    protected $state;
    
    /**
     * @ORM\Column(length=16)
     * @var string
     */
    protected $authority;
    
    /**
     * @ORM\Column(length=32)
     * @var string
     */
    protected $dataSource;
    
    /**
     * @ORM\Column(length=16)
     * @var string
     */
    protected $reserveNumber;
    
    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $shapeLength;
    
    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $shapeArea;
    
    /**
     * @ORM\Column(type="geometry", options={"geometry_type"="MULTIPOLYGON", "srid"=4326})
     * @var string
     */
    protected $geom;
    
    /**
     * @ORM\Column(type="datetimetz")
     * @var datetime
     */
    protected $timestampCreated;
}