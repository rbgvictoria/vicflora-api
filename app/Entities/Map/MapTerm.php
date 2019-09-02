<?php

namespace VicFlora\Entities\Map;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="maps", indexes={@ORM\Index(columns={"name"})})
 */
class AssertionTerm {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer 
     */
    protected $id;
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $label;
}