<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Pdcoperaciones
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Pdcoperaciones
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
     * @ORM\ManyToOne(targetEntity="Pdcorden", inversedBy="operaciones")
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
     * Set denominacion
     *
     * @param string $denominacion
     * @return Pdcoperaciones
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
     * @return Pdcoperaciones
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
     * @return Pdcoperaciones
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
