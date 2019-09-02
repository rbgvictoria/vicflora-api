<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="taxon_tree", schema="flora", indexes={
 *     @ORM\Index(columns={"node_number"}),
 *     @ORM\Index(columns={"highest_descendant_node_number"})
 * })
 */
class TaxonTree extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Taxon
     */
    protected $taxon;
    
    /**
     * @ORM\ManyToOne(targetEntity="TaxonTree")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @var \VicFlora\Entities\TaxonTree
     */
    protected $parent;
    
    /**
     * @ORM\Column(type="integer", name="node_number")
     * @var int
     */
    protected $nodeNumber;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    protected $highestDescendantNodeNumber;
    
    /**
     * @ORM\Column(type="smallint", nullable=false)
     * @var int
     */
    protected $depth;
}
