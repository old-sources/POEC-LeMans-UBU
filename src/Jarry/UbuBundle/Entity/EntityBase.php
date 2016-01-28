<?php

namespace Jarry\UbuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Events;

/**
 * EntityBase
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */

abstract class EntityBase{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;
    
    /** @ORM\PrePersist */
    public function setCreatedAtValue()
    {
        if(!$this->getCreatedAt())
        {
            $this->createdat = new \DateTime();
        }
    }
    
    /** @ORM\PreUpdate */
    public function setUpdatedAtValue(){
        $this->updatedat = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
