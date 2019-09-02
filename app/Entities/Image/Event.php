<?php

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="images")
 */
class Event extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Image\Location
     */
    protected $location;
    
    /**
     * @ORM\Column(type="date", name="start_date", nullable=true)
     * @var date
     */
    protected $startDate;
    
    /**
     * @ORM\Column(type="date", name="end_date", nullable=true)
     * @var date
     */
    protected $endDate;
}
