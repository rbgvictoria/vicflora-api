<?php

namespace VicFlora\Entities\Glossary;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="glossary")
 */
class Relationship extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Term")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Glossary\Term
     */
    protected $term;
    
    /**
     * @ORM\ManyToOne(targetEntity="Term")
     * @ORM\JoinColumn(name="related_term_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Glossary\Term
     */
    protected $relatedTerm;
    
    /**
     * @ORM\ManyToOne(targetEntity="RelationshipType")
     * @ORM\JoinColumn(name="relationship_type_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Glossary\RelationshipType
     */
    protected $relationshipType;
    
    /**
     * @ORM\ManyToOne(targetEntity="Limitation")
     * @ORM\JoinColumn(name="limitation_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Glossary\Limitation
     */
    protected $limitation;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $isMisapplied;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $isDiscouraged;
}
