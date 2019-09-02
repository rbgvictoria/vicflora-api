<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="flora", indexes={
 *     @ORM\Index(columns={"name"}),
 *     @ORM\Index(columns={"rank_id"})
 * })
 */
class TaxonTreeDefItem extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="TaxonTreeDefItem")
     * @ORM\JoinColumn(name="parent_item_id", referencedColumnName="id")
     * @var \VicFlora\Entities\TaxonTreeDefItem
     */
    protected $parentItem;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(length=16, nullable=true)
     * @var string
     */
    protected $textBefore;
    
    /**
     * @ORM\Column(length=16, nullable=true)
     * @var string
     */
    protected $textAfter;
    
    /**
     * @ORM\Column(length=4, nullable=true)
     * @var string
     */
    protected $fullNameSeparator;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $isEnforced;
    
        
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $isInFullName;
    
    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @var int
     */
    protected $rankId;

}
