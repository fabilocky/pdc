<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Terceros
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Terceros
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
     * @ORM\ManyToOne(targetEntity="Ordvolvo", inversedBy="terceros")
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
     * Set cantidad
     *
     * @param float $cantidad
     * @return Terceros
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
     * @return Terceros
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
     * @return Terceros
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
     * @return Terceros
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
