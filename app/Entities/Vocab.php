<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

class Vocab extends ClassBase {
    
    /**
     * @ORM\Column(length=40)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(length=128)
     * @var string
     */
    protected $uri;
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $label;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $description;
}
