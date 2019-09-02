<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="agent_type", indexes={
 *     @ORM\Index(columns={"name"}),
 *     @ORM\Index(columns={"uri"}),
 *     @ORM\Index(columns={"label"}),
 * })
 */
class AgentType extends Vocab {
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     */
    protected $uri;
    
    /**
     * @ORM\Column(length=64)
     * @var string
     */
    protected $label;
}
