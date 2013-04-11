<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Operaciones
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Operaciones
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
     * @ORM\ManyToOne(targetEntity="Ordvolvo", inversedBy="operaciones")
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
     * Set denominacion
     *
     * @param string $denominacion
     * @return Operaciones
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
     * @return Operaciones
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
     * @return Operaciones
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
