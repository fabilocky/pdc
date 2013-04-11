<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Operacionesrenault
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Operacionesrenault
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
     * @ORM\Column(name="hs", type="string")
     */
    private $hs;

    /**
     * @var string $subtotal
     *
     * @ORM\Column(name="subtotal", type="string")
     */
    private $subtotal;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ordrenault", inversedBy="operaciones")
     * @ORM\JoinColumn(name="ordrenault_id", referencedColumnName="id")
     * @var type 
     */
    private $ordrenault;

    
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
     * @return Operacionesrenault
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
     * @return Operacionesrenault
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
     * @return Operacionesrenault
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
     * Set ordrenault
     *
     * @param Sistema\AdminBundle\Entity\Ordrenault $ordrenault
     */
    public function setOrdrenault(\Sistema\AdminBundle\Entity\Ordrenault $ordrenault)
    {
        $this->ordrenault = $ordrenault;
    }
 
    /**
     * Get ordrenault
     *
     * @return Sistema\AdminBundle\Entity\Ordrenault 
     */
    public function getOrdrenault()
    {
        return $this->ordrenault;
    }
}
