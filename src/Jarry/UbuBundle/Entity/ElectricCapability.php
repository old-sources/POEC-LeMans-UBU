<?php

namespace Jarry\UbuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Events;
use Jarry\UbuBundle\Entity\MainCapability;

/**
 * @ORM\Entity
 * @ORM\Table(name="log_electric")
 */
class ElectricCapability extends MainCapability
{
    
    /**
     *@ORM\Column(type="boolean")
     */
    private $onOffActor;
    
    /**
     *@ORM\Column(type="float")
     */
    private $powerSensor;

    /**
     * Set onOffActor
     *
     * @param boolean $onOffActor
     *
     * @return ElectricCapability
     */
    public function setOnOffActor($onOffActor)
    {
        $this->onOffActor = $onOffActor;

        return $this;
    }

    /**
     * Get onOffActor
     *
     * @return boolean
     */
    public function getOnOffActor()
    {
        return $this->onOffActor;
    }

    /**
     * Set powerSensor
     *
     * @param float $powerSensor
     *
     * @return ElectricCapability
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