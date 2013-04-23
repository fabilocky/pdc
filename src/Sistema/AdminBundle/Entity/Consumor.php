<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Consumor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Consumor
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
     * @var string $subtotal
     *
     * @ORM\Column(name="subtotal", type="string")
     */
    private $subtotal;
    
    /**
     * @var boolean $garantía
     *
     * @ORM\Column(name="garantia", type="boolean")
     */
    private $garantia;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ordvolvo", inversedBy="consumos")
     * @ORM\JoinColumn(name="ordvolvo_id", referencedColumnName="id")
     * @var type 
     */
    private $ordvolvo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Remitovolvo", inversedBy="consumos")
     * @ORM\JoinColumn(name="remitovolvo_id", referencedColumnName="id")
     * @var type 
     */
    private $remitovolvo;
    
    /**
     * @var Renaultrepuestos
     *
     * @ORM\ManyToOne(targetEntity="Renaultrepuestos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_repvolvo", referencedColumnName="id")
     * })
     */
    private $idRenaultrepuestos;
        
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
     * @param integer $cantidad
     * @return Consumo
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }
    
    /**
     * Set garantia
     *
     * @param boolean $garantia
     * @return Consumo
     */
    public function setGarantia($garantia)
    {
        $this->garantia = $garantia;
    
        return $this;
    }

    /**
     * Get garantia
     *
     * @return boolean 
     */
    public function getGarantia()
    {
        return $this->garantia;
    }

    /**
     * Set subtotal
     *
     * @param float $subtotal
     * @return Consumo
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
    
    /**
     * Set remitovolvo
     *
     * @param Sistema\AdminBundle\Entity\Remitovolvo $remitovolvo
     */
    public function setRemitovolvo(\Sistema\AdminBundle\Entity\Remitovolvo $remitovolvo)
    {
        $this->remitovolvo = $remitovolvo;
    }
 
    /**
     * Get remitovolvo
     *
     * @return Sistema\AdminBundle\Entity\Remitovolvo
     */
    public function getRemitovolvo()
    {
        return $this->remitovolvo;
    }
    
    /**
     * Set idRenaultrepuestos
     *
     * @param Sistema\AdminBundle\Entity\Renaultrepuestos $idRenaultrepuestos
     * @return Consumo
     */
    public function setIdRenaultrepuestos(\Sistema\AdminBundle\Entity\Renaultrepuestos $idRenaultrepuestos = null)
    {
        $this->idRenaultrepuestos = $idRenaultrepuestos;
    
        return $this;
    }

    /**
     * Get idRenaultrepuestos
     *
     * @return Sistema\AdminBundle\Entity\Renaultrepuestos
     */
    public function getIdRenaultrepuestos()
    {
        return $this->idRenaultrepuestos;
    }
    
}
