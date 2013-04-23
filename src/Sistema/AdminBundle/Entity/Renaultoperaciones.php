<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Renaultoperaciones
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Renaultoperaciones
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
     * @var string $denominacion
     *
     * @ORM\Column(name="denominacion", type="string", length=255)
     */
    private $denominacion;

    /**
     * @var string $hs
     *
     * @ORM\Column(name="hs", type="string", nullable=true)
     */
    private $hs;

    /**
     * @var string $subtotal
     *
     * @ORM\Column(name="subtotal", type="string", nullable=true)
     */
    private $subtotal;
    
    /**
     * @ORM\ManyToOne(targetEntity="Renaultorden", inversedBy="operaciones")
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
     * Set denominacion
     *
     * @param string $denominacion
     * @return Renaultoperaciones
     */
    public function setDenominacion($denominacion)
    {
        $this->denominacion = $denominacion;
    
        return $this;
    }

    /**
     * Get denominacion
     *
     * @return string 
     */
    public function getDenominacion()
    {
        return $this->denominacion;
    }

    /**
     * Set hs
     *
     * @param float $hs
     * @return Renaultoperaciones
     */
    public function setHs($hs)
    {
        $this->hs = $hs;
    
        return $this;
    }

    /**
     * Get hs
     *
     * @return float 
     */
    public function getHs()
    {
        return $this->hs;
    }

    /**
     * Set subtotal
     *
     * @param float $subtotal
     * @return Renaultoperaciones
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    
        return $this;
    }

    /**
     * Get subtotal
     *
     * @return float 
     */
    public function getSubtotal()
    {
        return $this->subtotal;
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
