<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Pdcterceros
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Pdcterceros
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
     * @ORM\ManyToOne(targetEntity="Pdcorden", inversedBy="terceros")
     * @ORM\JoinColumn(name="pdcorden_id", referencedColumnName="id")
     * @var type 
     */
    private $pdcorden;


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
     * @return Pdcterceros
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
     * @return Pdcterceros
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
     * @return Pdcterceros
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
     * @return Pdcterceros
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
     * Set pdcorden
     *
     * @param Sistema\AdminBundle\Entity\Pdcorden $pdcorden
     */
    public function setPdcorden(\Sistema\AdminBundle\Entity\Pdcorden $pdcorden)
    {
        $this->pdcorden = $pdcorden;
    }
 
    /**
     * Get pdcorden
     *
     * @return Sistema\AdminBundle\Entity\Pdcorden 
     */
    public function getPdcorden()
    {
        return $this->pdcorden;
    }
}
