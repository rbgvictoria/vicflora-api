<?php

namespace VicFlora\Entities\Map;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="maps", indexes={
 *     @ORM\Index(columns={"is_current"})
 * })
 */
class Assertion {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer 
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="MapOccurrence")
     * @ORM\JoinColumn(name="occurrence_id", referencedColumnName="uuid")
     * @var \VicFlora\Entities\Map\MapOccurrence
     */
    protected $occurrence;
    
    /**
     * @ORM\ManyToOne(targetEntity="AssertionTerm")
     * @ORM\JoinColumn(name="assertion_term_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Map\AssertionTerm 
     */
    protected $assertionTerm;
    
    /**
     * @ORM\Column(length=128)
     * @var string
     */
    protected $assertinValue;
    
    /**
     * @ORM\ManyToOne(targetEntity="AssertionScope")
     * @ORM\JoinColumn(name="assertion_scope_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Map\AssertionScope
     */
    protected $assertionScope;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $assertionRemarks;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $isCurrent;
    
    /**
     * @ORM\ManyToOne(targetEntity="\VicFlora\Entities\Agent")
     * @ORM\JoinColumn(name="assertion_agent_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Agent
     */
    protected $assertionAgent;
    
    /**
     * @ORM\Column(type="smallint")
     * @var integer;
     */
    protected $version;
    
    /**
     * @ORM\Column(type="datetimetz")
     * @var datetime
     */
    protected $timestampCreated;
    
    /**
     * @ORM\Column(type="datetimetz")
     * @var datetime
     */
    protected $timestampModified;
}