<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="flora")
 */
class Treatment extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Taxon
     */
    protected $taxon;
    
    /**
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="accepted_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Taxon
     */
    protected $accepted;
    
    /**
     * @ORM\ManyToOne(targetEntity="TaxonomicStatus")
     * @ORM\JoinColumn(name="taxonomic_status_id", referencedColumnName="id")
     * @var \VicFlora\Entities\TaxonomicStatus
     */
    protected $taxonomicStatus;
    
    /**
     * @ORM\ManyToOne(targetEntity="Reference")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Reference
     */
    protected $source;
    
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $html;
    
    /**
     * @ORM\Column(type="boolean", name="is_current", nullable=true)
     * @var bool
     */
    protected $isCurrent;
    
    /**
     * @ORM\Column(type="boolean", name="is_updated", nullable=true)
     * @var bool
     */
    protected $isUpdated;
}
