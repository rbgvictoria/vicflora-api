<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="flora")
 */
class TaxonAttribute extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Taxon
     */
    protected $taxon;
    
    /**
     * @ORM\ManyToOne(targetEntity="Attribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Attribute
     */
    protected $attribute;
    
    /**
     * @ORM\Column(name="attribute_value")
     * @var string
     */
    protected $value;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $remarks;
}
