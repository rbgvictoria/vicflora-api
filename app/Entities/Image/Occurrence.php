<?php

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="images")
 */
class Occurrence extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Image\Event
     */
    protected $event;
    
    /**
     * @ORM\ManyToOne(targetEntity="\VicFlora\Entities\Agent")
     * @ORM\JoinColumn(name="recorded_by_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Agent
     */
    protected $recordedBy;
    
    /**
     * @ORM\Column(type="string", name="catalog_number", length=32, 
     *     nullable=true)
     * @var string
     */
    protected $catalogNumber;
    
    /**
     * @ORM\Column(type="string", name="record_number", length=32, 
     *     nullable=true)
     * @var string
     */
    protected $recordNumber;
}
