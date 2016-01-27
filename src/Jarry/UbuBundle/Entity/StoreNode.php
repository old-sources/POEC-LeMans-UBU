<?php

namespace Jarry\UbuBundle\Entity;

use Jarry\UbuBundle\Entity\Node;
use Jarry\UbuBundle\Entity\ElectricCapability;
use Jarry\UbuBundle\Entity\StoreCapability;
use Jarry\UbuBundle\Entity\MainCapability;

/**
 * LightningNode
 */
class LightningNode extends Node
{
        private $capabilityList = array ();
        
        public function __construct() {
            $capabilityList[] = new ElectricCapability();
            $capabilityList[] = new StoreCapability();
            $capabilityList[] = new MainCapability();
        }
}