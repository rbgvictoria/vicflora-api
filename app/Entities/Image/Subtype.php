<?php

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\Vocab;

/**
 * @ORM\Entity()
 * @ORM\Table(name="subtype_vocab", schema="vocab", indexes={
 *     @ORM\Index(columns={"name"}),
 *     @ORM\Index(columns={"uri"}),
 *     @ORM\Index(columns={"label"}),
 * })
 */
class Subtype extends Vocab {
    
}
