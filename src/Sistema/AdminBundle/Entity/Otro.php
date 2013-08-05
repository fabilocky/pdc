<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Otro
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Otro
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
     * @var string $codigo
     *
     * @ORM\Column(name="codigo", type="string")
     */
    private $codigo;
    
    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string")
     */
    private $descripcion;
    
    /**
     * @var string $precio
     *
     * @ORM\Column(name="precio", type="string")
     */
    private $precio;

    /**
     * @var float $cantidad
     *
     * @ORM\Column(name="cantidad", type="float")
     */
    private $cantidad;    

    /**
     * @var string $subtotal
     *
     * @ORM\Column(name="subtotal", type="string")
     */
    private $subtotal;   
    
    /**
     * @ORM\ManyToOne(targetEntity="Ordvolvo", inversedBy="otros")
     * @ORM\JoinColumn(name="ordvolvo_id", referencedColumnName="id")
     * @var type 
     */
    private $ordvolvo;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Renaultorden", inversedBy="otros")
     * @ORM\JoinColumn(name="renaultorden_id", referencedColumnName="id")
     * @var type 
     */
    private $renaultorden;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pdcorden", inversedBy="otros")
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
     * @param integer $cantidad
     * @return Otro
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
     * Set subtotal
     *
     * @param float $subtotal
     * @return Otro
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
     * Set descripcion
     *
     * @param float $descripcion
     * @return Otro
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return float 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    /**
     * Set codigo
     *
     * @param float $codigo
     * @return Otro
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return float 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }
    
    /**
     * Set precio
     *
     * @param float $precio
     * @return Otro
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    
        return $this;
    }

    /**
     * Get precio
     *
     * @return float 
     */
    public function getPrecio()
    {
        return $this->precio;
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
