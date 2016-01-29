<?php

namespace Jarry\UbuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Events;
use Jarry\UbuBundle\Entity\MainCapability;

/**
 * @ORM\Entity
 * @ORM\Table(name="log_store")
 */
class StoreCapability extends MainCapability
{
    /**
     *@ORM\Column(type="boolean")
     */
    private $upDownActor;
    /**
     *@ORM\Column(type="float")
     */
    private $dimmerActor;
    /**
     *@ORM\Column(type="float")
     */
    private $upSensor;
    /**
     *@ORM\Column(type="float")
     */
    private $downSensor;
    /**
     *@ORM\Column(type="float")
     */
    private $luxSensor;
    /**
     *@ORM\Column(type="float")
     */
    private $encoderSensor;

    /**
     * Set upDownActor
     *
     * @param boolean $upDownActor
     *
     * @return StoreCapability
     */
    public function setUpDownActor($upDownActor)
    {
        $this->upDownActor = $upDownActor;

        return $this;
    }

    /**
     * Get upDownActor
     *
     * @return boolean
     */
    public function getUpDownActor()
    {
        return $this->upDownActor;
    }

    /**
     * Set dimmerActor
     *
     * @param float $dimmerActor
     *
     * @return StoreCapability
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
     * Set upSensor
     *
     * @param float $upSensor
     *
     * @return StoreCapability
     */
    public function setUpSensor($upSensor)
    {
        $this->upSensor = $upSensor;

        return $this;
    }

    /**
     * Get upSensor
     *
     * @return float
     */
    public function getUpSensor()
    {
        return $this->upSensor;
    }

    /**
     * Set downSensor
     *
     * @param float $downSensor
     *
     * @return StoreCapability
     */
    public function setDownSensor($downSensor)
    {
        $this->downSensor = $downSensor;

        return $this;
    }

    /**
     * Get downSensor
     *
     * @return float
     */
    public function getDownSensor()
    {
        return $this->downSensor;
    }

    /**
     * Set luxSensor
     *
     * @param float $luxSensor
     *
     * @return StoreCapability
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
     * Set encoderSensor
     *
     * @param float $encoderSensor
     *
     * @return StoreCapability
     */
    public function setEncoderSensor($encoderSensor)
    {
        $this->encoderSensor = $encoderSensor;

        return $this;
    }

    /**
     * Get encoderSensor
     *
     * @return float
     */
    public function getEncoderSensor()
    {
        return $this->encoderSensor;
    }
}