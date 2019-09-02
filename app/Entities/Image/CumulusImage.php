<?php

namespace VicFlora\Entities\Image;

use Doctrine\ORM\Mapping as ORM;
use VicFlora\Entities\ClassBase;

/**
 * @ORM\Entity()
 * @ORM\Table(schema="cumulus", indexes={
 *     @ORM\Index(columns={"cumulus_catalogue"}),
 *     @ORM\Index(columns={"cumulus_record_id"}),
 * })
 */
class CumulusImage extends ClassBase {
    
    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Image\Image
     */
    protected $image;
    
    /**
     * @ORM\Column(type="integer", name="cumulus_record_id", nullable=true)
     * @var int
     */
    protected $cumulusRecordID;
    
    /**
     * @ORM\Column(type="string", name="cumulus_catalogue", length=64, nullable=true)
     * @var string
     */
    protected $cumulusCatalogue;
    
    /**
     * @ORM\Column(type="string", name="cumulus_record_name", length=64, nullable=true)
     * @var string
     */
    protected $cumulusRecordName;
    
    
    /**
     * @ORM\Column(type="datetime", name="cumulus_modified", nullable=true)
     * @var datetime
     */
    protected $cumulusModified;
    
    /**
     * @ORM\Column(type="boolean", name="thumbnail_url_enabled")
     * @var bool
     */
    protected $thumbnailUrlEnabled;
    
    /**
     * @ORM\Column(type="boolean", name="preview_url_enabled")
     * @var bool
     */
    protected $previewUrlEnabled;

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
