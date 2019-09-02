<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="flora")
 */
class TaxonReference extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Taxon
     */
    protected $taxon;
    
    /**
     * @ORM\ManyToOne(targetEntity="Reference")
     * @ORM\JoinColumn(name="reference_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Reference
     */
    protected $reference;
    
}
