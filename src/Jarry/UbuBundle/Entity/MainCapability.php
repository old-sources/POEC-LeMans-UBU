<?php

namespace Jarry\UbuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Events;

/**
 * @ORM\Entity
 * @ORM\Table(name="log_main")
 */
class MainCapability
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOfLog;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nodeName;
    
    /**
     * @ORM\Column(type="bigint")
     */
    private $nodeId;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zoneName;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $zoneId;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $placeName;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $placeId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="capabilities")
     * @ORM\JoinColumn(name="node_id", referencedColumnName="id")
     */
    private $node;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateOfLog
     *
     * @param \DateTime $dateOfLog
     *
     * @return MainCapability
     */
    public function setDateOfLog($dateOfLog)
    {
        $this->dateOfLog = $dateOfLog;

        return $this;
    }

    /**
     * Get dateOfLog
     *
     * @return \DateTime
     */
    public function getDateOfLog()
    {
        return $this->dateOfLog;
    }

    /**
     * Set nodeName
     *
     * @param string $nodeName
     *
     * @return MainCapability
     */
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;

        return $this;
    }

    /**
     * Get nodeName
     *
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }

    /**
     * Set nodeId
     *
     * @param integer $nodeId
     *
     * @return MainCapability
     */
    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;

        return $this;
    }

    /**
     * Get nodeId
     *
     * @return integer
     */
    public function getNodeId()
    {
        return $this->nodeId;
    }

    /**
     * Set zoneName
     *
     * @param string $zoneName
     *
     * @return MainCapability
     */
    public function setZoneName($zoneName)
    {
        $this->zoneName = $zoneName;

        return $this;
    }

    /**
     * Get zoneName
     *
     * @return string
     */
    public function getZoneName()
    {
        return $this->zoneName;
    }

    /**
     * Set zoneId
     *
     * @param integer $zoneId
     *
     * @return MainCapability
     */
    public function setZoneId($zoneId)
    {
        $this->zoneId = $zoneId;

        return $this;
    }

    /**
     * Get zoneId
     *
     * @return integer
     */
    public function getZoneId()
    {
        return $this->zoneId;
    }

    /**
     * Set placeName
     *
     * @param string $placeName
     *
     * @return MainCapability
     */
    public function setPlaceName($placeName)
    {
        $this->placeName = $placeName;

        return $this;
    }

    /**
     * Get placeName
     *
     * @return string
     */
    public function getPlaceName()
    {
        return $this->placeName;
    }

    /**
     * Set placeId
     *
     * @param integer $placeId
     *
     * @return MainCapability
     */
    public function setPlaceId($placeId)
    {
        $this->placeId = $placeId;

        return $this;
    }

    /**
     * Get placeId
     *
     * @return integer
     */
    public function getPlaceId()
    {
        return $this->placeId;
    }

    /**
     * Set node
     *
     * @param \Jarry\UbuBundle\Entity\Node $node
     *
     * @return MainCapability
     */
    public function setNode(\Jarry\UbuBundle\Entity\Node $node = null)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return \Jarry\UbuBundle\Entity\Node
     */
    public function getNode()
    {
        return $this->node;
    }
}