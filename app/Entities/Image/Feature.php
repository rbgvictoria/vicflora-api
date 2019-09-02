<?php

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\Vocab;

/**
 * @ORM\Entity()
 * @ORM\Table(name="feature_vocab", schema="vocab", indexes={
 *     @ORM\Index(columns={"name"}),
 *     @ORM\Index(columns={"uri"}),
 *     @ORM\Index(columns={"label"}),
 * })
 */
class Feature extends Vocab {
    
    /**
     * @ORM\ManyToOne(targetEntity="Feature")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Vocab
     */
    protected $parent;
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $node_number;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $highest_descendant_node_number;
    
}
