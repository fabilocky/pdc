<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Renaultsolicrep
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Renaultsolicrep
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Renaultorden", inversedBy="solicitudes")
     * @ORM\JoinColumn(name="renaultorden_id", referencedColumnName="id")
     * @var type 
     */
    private $renaultorden;
    
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Renaultsolicrep
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    /**
     * Set renaultorden
     *
     * @param Sistema\AdminBundle\Entity\Renaultorden $renaultorden
     */
    public function setRenaultorden(\Sistema\AdminBundle\Entity\Renaultorden $renaultorden)
    {
        $this->renaultorden = $renaultorden;
    }
 
    /**
     * Get renaultorden
     *
     * @return Sistema\AdminBundle\Entity\Renaultorden 
     */
    public function getRenaultorden()
    {
        return $this->renaultorden;
    }
}
