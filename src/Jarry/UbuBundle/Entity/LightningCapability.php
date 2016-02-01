<?php

namespace Jarry\UbuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Events;
use Jarry\UbuBundle\Entity\MainCapability;

/**
 * @ORM\Entity
 * @ORM\Table(name="log_lightning")
 */
class LightningCapability extends MainCapability
{    
    /**
     *@ORM\Column(type="float")
     */
    private $dimmerActor;
    /**
     *@ORM\Column(type="string", length=255)
     */
    private $colorActor;
    /**
     *@ORM\Column(type="float")
     */
    private $luxSensor;
    /**
     *@ORM\Column(type="float")
     */
    private $powerSensor;

    /**
     * Set dimmerActor
     *
     * @param float $dimmerActor
     *
     * @return LightningCapability
     */
    public function setDimmerActor($dimmerActor)
    {
        $this->dimmerActor = $dimmerActor;

        return $this;
    }

    /**
     * Get dimmerActor
     *
     * @return float
     */
    public function getDimmerActor()
    {
        return $this->dimmerActor;
    }

    /**
     * Set colorActor
     *
     * @param string $colorActor
     *
     * @return LightningCapability
     */
    public function setColorActor($colorActor)
    {
        $this->colorActor = $colorActor;

        return $this;
    }

    /**
     * Get colorActor
     *
     * @return string
     */
    public function getColorActor()
    {
        return $this->colorActor;
    }

    /**
     * Set luxSensor
     *
     * @param float $luxSensor
     *
     * @return LightningCapability
     */
    public function setLuxSensor($luxSensor)
    {
        $this->luxSensor = $luxSensor;

        return $this;
    }

    /**
     * Get luxSensor
     *
     * @return float
     */
    public function getLuxSensor()
    {
        return $this->luxSensor;
    }

    /**
     * Set powerSensor
     *
     * @param float $powerSensor
     *
     * @return LightningCapability
     */
    public function setPowerSensor($powerSensor)
    {
        $this->powerSensor = $powerSensor;

        return $this;
    }

    /**
     * Get powerSensor
     *
     * @return float
     */
    public function getPowerSensor()
    {
        return $this->powerSensor;
    }
}