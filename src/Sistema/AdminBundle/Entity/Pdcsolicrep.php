<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sistema\AdminBundle\Entity\Pdcsolicrep
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Pdcsolicrep
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
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Pdcorden", inversedBy="solicitudes")
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Pdcsolicrep
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
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
