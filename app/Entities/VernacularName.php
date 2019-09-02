<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="flora", indexes={
 *     @ORM\Index(columns={"vernacular_name"}),
 *     @ORM\Index(columns={"is_preferred_name"}),
 * })
 */
class VernacularName extends ClassBase {
    
    /**
     * http://rs.tdwg.org/dwc/terms/vernacularName
     * 
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="id", 
     *     nullable=false)
     * @var \VicFlora\Entities\Taxon
     */
    protected $taxon;
    
    /**
     * http://purl.org/dc/terms/source
     * 
     * @ORM\ManyToOne(targetEntity="Reference")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
     * @var type \VicFlora\Entities\Reference
     */
    protected $source;
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $vernacularName;
    
    /**
     * http://rs.gbif.org/terms/1.0/isPreferredName
     * 
     * This term is true if the source citing the use of this vernacular name 
     * indicates the usage has some preference or specific standing over other 
     * possible vernacular names used for the species.
     * 
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $isPreferredName;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $vernacularNameUsage;
    
    /**
     * @ORM\Column(length=2, nullable=true)
     * @var string 
     */
    protected $language;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string
     */
    protected $organismPart;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $taxonRemarks;
}
