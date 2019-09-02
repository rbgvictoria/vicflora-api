<?php
namespace VicFlora\Entities;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\MappedSuperclass 
 */
class ClassBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var integer 
     */
    protected $id;
    
    /** 
     * @ORM\Column(type="datetimetz", name="timestamp_created")
     * @var datetime
     */
    protected $timestampCreated;
    
    /** 
     * @ORM\Column(type="datetimetz", name="timestamp_modified", nullable=true) 
     * @var datetime
     */
    protected $timestampModified;
    
    /**
     * @ORM\Column(type="guid", nullable=true)
     * @var string
     */
    protected $guid;
    
    /**
     * @ORM\Column(type="smallint")
     * @var integer 
     */
    protected $version;
    
    /**
     * @ORM\ManyToOne(targetEntity="\VicFlora\Entities\Agent")
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="id")
     */
    protected $createdBy;
    
    /**
     * @ORM\ManyToOne(targetEntity="\VicFlora\Entities\Agent")
     * @ORM\JoinColumn(name="modified_by_id", referencedColumnName="id")
     */
    protected $modifiedBy;
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return datetime
     */
    public function getTimestampCreated()
    {
        return $this->timestampCreated;
    }
    
    /**
     * 
     * @param datetime $timestamp
     */
    public function setTimestampCreated($timestamp)
    {
        $this->timestampCreated = $timestamp;
    }
    
    /**
     * @return datetime
     */
    public function getTimestampModified()
    {
        return $this->timestampModified;
    }
    
    /**
     * @param datetime $timestamp
     */
    public function setTimestampModified($timestamp)
    {
        $this->timestampModified = $timestamp;
    }
    
    /**
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }
    
    /**
     * @param integer $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }
    
    public function incrementVersion() {
        $this->version++;
    }
    
    /**
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }
    
    
    /**
     * @param string $guid
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
    }
    
    /**
     * @return /KeyBase/Entities/Agent
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * @param /KeyBase/Entities/Agent $agent
     */
    public function setCreatedBy($agent)
    {
        $this->createdBy = $agent;
    }
    
    /**
     * @return /KeyBase/Entities/Agent
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }
    
    /**
     * @param /KeyBase/Entities/Agent $agent
     */
    public function setModifiedBy($agent)
    {
        $this->modifiedBy = $agent;
    }
}