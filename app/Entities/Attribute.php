<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="flora", indexes={
 *     @ORM\Index(columns={"name"}),
 *     @ORM\Index(columns={"label"}),
 * })
 */
class Attribute extends ClassBase {
    
    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $label;
}
