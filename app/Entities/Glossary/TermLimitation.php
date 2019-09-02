<?php

namespace VicFlora\Entities\Glossary;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(name="terms_limitations", schema="glossary")
 */
class TermLimitation extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Term")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Term
     */
    protected $term;
    
    /**
     * @ORM\ManyToOne(targetEntity="Limitation")
     * @ORM\JoinColumn(name="limitation_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Limitation
     */
    protected $limitation;
}
