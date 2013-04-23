<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Renaultterceros
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Renaultterceros
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
     * @var integer $cantidad
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;    

    /**
     * @var string $denominacion
     *
     * @ORM\Column(name="denominacion", type="string", length=255)
     */
    private $denominacion;

    /**
     * @var string $unitario
     *
     * @ORM\Column(name="unitario", type="string")
     */
    private $unitario;

    /**
     * @var string $subtotal
     *
     * @ORM\Column(name="subtotal", type="string")
     */
    private $subtotal;
    
    /**
     * @ORM\ManyToOne(targetEntity="Renaultorden", inversedBy="terceros")
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
     * Set cantidad
     *
     * @param float $cantidad
     * @return Renaultterceros
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad
     *
     * @return float 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }    

    /**
     * Set denominacion
     *
     * @param string $denominacion
     * @return Renaultterceros
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
     * Set unitario
     *
     * @param float $unitario
     * @return Renaultterceros
     */
    public function setUnitario($unitario)
    {
        $this->unitario = $unitario;
    
        return $this;
    }

    /**
     * Get unitario
     *
     * @return float 
     */
    public function getUnitario()
    {
        return $this->unitario;
    }

    /**
     * Set subtotal
     *
     * @param float $subtotal
     * @return Renaultterceros
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
