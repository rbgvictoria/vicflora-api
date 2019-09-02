<?php
namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class GroupAgent extends ClassBase
{
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Agent
     */
    protected $member;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agent")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Agent
     */
    protected $group;
    
    /**
     * @ORM\Column(type="smallint")
     * @var smallint
     */
    protected $sequence;
}