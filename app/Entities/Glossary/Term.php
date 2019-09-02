<?php

namespace VicFlora\Entities\Glossary;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="glossary")
 */
class Term extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Category
     */
    protected $category;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $definition;
    
    /**
     * @ORM\Column(length=8, nullable=true)
     * @var string
     */
    protected $scope;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $isDiscouraged;
    
    /**
     * @ORM\Column(length=2, nullable=true)
     * @var string
     */
    protected $language;
}
