<?php
namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Reference
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class Reference extends ClassBase {
     
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $reference;
    
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @var string
     */
    protected $author;
    
    /**
     * @ORM\Column(type="string", name="publication_year", length=16, 
     *     nullable=true)
     * @var string
     */
    protected $publicationYear;

    /** 
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @var string
     */
    protected $journalOrBook;
    
    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     * @var string
     */
    protected $collation;
    
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     * @var string
     */
    protected $series;
    
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     * @var string
     */
    protected $edition;
    
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     * @var string
     */
    protected $volume;
    
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     * @var string
     */
    protected $part;
    
    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     * @var string
     */
    protected $page;
    

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $publisher;
    
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $placeOfPublication;
    
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @var string
     */
    protected $subject;
    
    /**
     * @ORM\ManyToOne(targetEntity="Reference")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * @var \VicFlora\Entities\Reference
     */
    protected $parent;
}
