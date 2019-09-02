<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="flora", indexes={
 *     @ORM\Index(columns={"name"}),
 *     @ORM\Index(columns={"full_name"}),
 *     @ORM\Index(columns={"authorship"})
 * })
 */
class Name extends ClassBase {
    
    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", name="full_name", length=255)
     * @var string
     */
    protected $fullName;
    
    /**
     * @ORM\Column(type="string", name="authorship", length=255, nullable=true)
     * @var string
     */
    protected $authorship;
    
    /**
     * @ORM\Column(type="string", name="nomenclatural_note", length=255, nullable=true)
     * @var string
     */
    protected $nomenclaturalNote;
    
    /**
     * @ORM\ManyToOne(targetEntity="Reference")
     * @ORM\JoinColumn(name="protologue_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Reference
     */
    protected $protologue;
    
    /**
     * @ORM\ManyToOne(targetEntity="NameType")
     * @ORM\JoinColumn(name="name_type_id", referencedColumnName="id")
     * @var \VicFlora\Entities\NameType
     */
    protected $nameType;
}
