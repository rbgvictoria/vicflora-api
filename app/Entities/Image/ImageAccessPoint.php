<?php

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="images",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="image_variant_idx", 
 *         columns={"image_id", "variant_id"})})
 */
class ImageAccessPoint extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", 
     *   nullable=false)
     * @var \VicFlora\Entities\Image\Image
     */
    protected $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="Variant")
     * @ORM\JoinColumn(name="variant_id", referencedColumnName="id", 
     *   nullable=false)
     * @var \VicFlora\Entities\Image\Variant
     */
    protected $variant;
    
    /**
     * @ORM\Column(name="access_uri", length=128, unique=true)
     * @var string
     */
    protected $accessUri;
    
    /**
     * @ORM\Column(length=32)
     * @var string
     */
    protected $format;
    
    /**
     * @ORM\Column(type="integer", name="pixel_x_dimension", nullable=true)
     * @var int
     */
    protected $pixelXDimension;
    
    /**
     * @ORM\Column(type="integer", name="pixel_y_dimension", nullable=true)
     * @var int
     */
    protected $pixelYDimension;
}
