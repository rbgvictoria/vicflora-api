<?php

namespace VicFlora\Entities\Map;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="maps", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="uniq_occurrence_region", 
 *         columns={"occurrence_id", "region_id"})
 * })
 */
class OccurrenceRegion {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer 
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="MapOccurrence")
     * @ORM\JoinColumn(name="occurrence_id", referencedColumnName="uuid")
     * @var \VicFlora\Entities\Map\MapOccurrence
     */
    protected $occurrence;
    
    /**
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Map\Bioregion
     */
    protected $region;
    
    /**
     * @ORM\Column(type="datetimetz")
     * @var datetime
     */
    protected $timestampCreated;
}