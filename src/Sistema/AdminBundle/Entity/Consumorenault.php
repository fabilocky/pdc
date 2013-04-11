<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Consumorenault
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Consumorenault
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
     * @ORM\ManyToOne(targetEntity="Ordrenault", inversedBy="consumos")
     * @ORM\JoinColumn(name="ordrenault_id", referencedColumnName="id")
     * @var type 
     */
    private $ordrenault;   
    
    
    /**
     * @var Reprenault
     *
     * @ORM\ManyToOne(targetEntity="Reprenault")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_reprenault", referencedColumnName="id")
     * })
     */
    private $idReprenault;
        
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
     * @return Consumorenault
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
     * @return Consumorenault
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
    
    
    /**
     * Set idReprenault
     *
     * @param Sistema\AdminBundle\Entity\Reprenault $idReprenault
     * @return Consumorenault
     */
    public function setIdReprenault(\Sistema\AdminBundle\Entity\Reprenault $idReprenault = null)
    {
        $this->idReprenault = $idReprenault;
    
        return $this;
    }

    /**
     * Get idReprenault
     *
     * @return Sistema\AdminBundle\Entity\Reprenault
     */
    public function getIdReprenault()
    {
        return $this->idReprenault;
    }
    
}
