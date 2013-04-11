<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Solicrep
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Solicrep
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
     * @ORM\ManyToOne(targetEntity="Ordvolvo", inversedBy="solicitudes")
     * @ORM\JoinColumn(name="ordvolvo_id", referencedColumnName="id")
     * @var type 
     */
    private $ordvolvo;
    
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
     * @return Solicrep
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
     * Set ordvolvo
     *
     * @param Sistema\AdminBundle\Entity\Ordvolvo $ordvolvo
     */
    public function setOrdvolvo(\Sistema\AdminBundle\Entity\Ordvolvo $ordvolvo)
    {
        $this->ordvolvo = $ordvolvo;
    }
 
    /**
     * Get ordvolvo
     *
     * @return Sistema\AdminBundle\Entity\Ordvolvo 
     */
    public function getOrdvolvo()
    {
        return $this->ordvolvo;
    }
}
