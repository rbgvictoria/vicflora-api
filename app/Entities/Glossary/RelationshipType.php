<?php

namespace VicFlora\Entities\Glossary;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="glossary")
 */
class RelationshipType extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="RelationshipType")
     * @ORM\JoinColumn(name="inverse_relationship_type_id", referencedColumnName="id")
     * @var \VicFlora\Entities\RelationshipType
     */
    protected $inverseRelationshipType;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(length=8, nullable=true)
     * @var string
     */
    protected $shorthand;
}
