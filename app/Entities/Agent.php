<?php
namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Agent extends ClassBase
{
    
    /**
     * @ORM\ManyToOne(targetEntity="AgentType")
     * @ORM\JoinColumn(name="agent_type_id", referencedColumnName="id")
     * @var \VicFlora\Entities\AgentType
     */
    protected $agentType;
    
    /**
     * @ORM\Column(length=128)
     * @var string 
     */
    protected $name;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string 
     */
    protected $firstName;
    
    /**
     * @ORM\Column(length=64, nullable=true)
     * @var string 
     */
    protected $lastName;
    
    /**
     * @ORM\Column(length=32, nullable=true)
     * @var string
     */
    protected $initials;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string 
     */
    protected $legalName;
    
    /**
     * @ORM\Column(length=128, nullable=true)
     * @var string
     */
    protected $email;
    
    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var type 
     */
    protected $user;
    
}