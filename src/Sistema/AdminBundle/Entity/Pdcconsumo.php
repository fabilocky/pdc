<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Pdcconsumo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Pdcconsumo
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
     * @ORM\ManyToOne(targetEntity="Pdcorden", inversedBy="consumos")
     * @ORM\JoinColumn(name="pdcorden_id", referencedColumnName="id")
     * @var type 
     */
    private $pdcorden;
    
    /**
     * @ORM\ManyToOne(targetEntity="Remitovolvo", inversedBy="consumos")
     * @ORM\JoinColumn(name="remitovolvo_id", referencedColumnName="id")
     * @var type 
     */
    private $remitovolvo;
    
    /**
     * @var Repvolvo
     *
     * @ORM\ManyToOne(targetEntity="Repvolvo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_repvolvo", referencedColumnName="id")
     * })
     */
    private $idRepvolvo;
        
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
     * @return Pdcconsumo
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
     * @return Pdcconsumo
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
     * @return Pdcconsumo
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
     * Set idRepvolvo
     *
     * @param Sistema\AdminBundle\Entity\Repvolvo $idRepvolvo
     * @return Pdcconsumo
     */
    public function setIdRepvolvo(\Sistema\AdminBundle\Entity\Repvolvo $idRepvolvo = null)
    {
        $this->idRepvolvo = $idRepvolvo;
    
        return $this;
    }

    /**
     * Get idRepvolvo
     *
     * @return Sistema\AdminBundle\Entity\Repvolvo
     */
    public function getIdRepvolvo()
    {
        return $this->idRepvolvo;
    }
    
}
