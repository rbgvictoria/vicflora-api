<?php

namespace VicFlora\Entities\Glossary;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(name="categories", schema="glossary")
 */
class Category extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Term")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Glossary\Term
     */
    protected $term;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $name;
}
