<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="flora")
 */
class Change extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="from_taxon_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Taxon
     */
    protected $fromTaxon;
    
    /**
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="to_taxon_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Taxon
     */
    protected $toTaxon;
    
    /**
     * @ORM\Column(nullable=true)
     * @var string
     */
    protected $source;
    
    /**
     * @ORM\Column(name="change_type", length=64, nullable=true)
     * @var string
     */
    protected $changeType;
    
    /**
     * @ORM\Column(type="boolean", name="is_current", nullable=true)
     * @var bool
     */
    protected $isCurrent;
}
