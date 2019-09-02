<?php

namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="establishment_means_vocab", schema="vocab", indexes={
 *     @ORM\Index(columns={"name"}),
 *     @ORM\Index(columns={"uri"}),
 *     @ORM\Index(columns={"label"}),
 * })
 */
class EstablishmentMeans extends Vocab {
    
}
