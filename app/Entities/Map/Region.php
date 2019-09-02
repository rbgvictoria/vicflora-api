<?php

namespace VicFlora\Entities\Map;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="maps", indexes={
 *     @ORM\Index(columns={"geom"}, flags={"spatial"})
 * })
 */
class Region {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer 
     */
    protected $id;
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(length=16)
     * @var string
     */
    protected $code;
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $type;
    
    /**
     * @ORM\Column(length=8, nullable=true)
     * @var string
     */
    protected $depiCode;
    
    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @var int
     */
    protected $depiOrder;
    
    /**
     * @ORM\Column(length=32)
     * @var string
     */
    protected $dataSource;

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
     * @ORM\Column(type="geometry", options={"geometry_type"="MULTIPOLYGON", 
     *     "srid"=4326})
     * @var string
     */
    protected $geom;
    
    /**
     * @ORM\Column(type="datetimetz")
     * @var datetime
     */
    protected $timestampCreated;
}