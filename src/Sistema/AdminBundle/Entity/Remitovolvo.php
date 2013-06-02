<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sistema\AdminBundle\Entity\Remitovolvo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sistema\AdminBundle\Entity\RemitovolvoRepository")
 */
class Remitovolvo
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
     * @var \DateTime $fecha
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string $cliente
     *
     * @ORM\Column(name="cliente", type="string", length=255)
     */
    private $cliente;

    /**
     * @var string $chasis
     *
     * @ORM\Column(name="chasis", type="string", length=255, nullable=true)
     */
    private $chasis;

    /**
     * @var string $cotizacion
     *
     * @ORM\Column(name="cotizacion", type="string", length=255)
     */
    private $cotizacion;

    /**
     * @var string $modelo
     *
     * @ORM\Column(name="modelo", type="string", length=255, nullable=true)
     */
    private $modelo;

    /**
     * @var string $dominio
     *
     * @ORM\Column(name="dominio", type="string", length=255, nullable=true)
     */
    private $dominio;
    
    /**
     * @var string $neto
     *
     * @ORM\Column(name="neto", type="string", length=255)
     */
    private $neto;

    /**
     * @var string $aclaracion
     *
     * @ORM\Column(name="aclaracion", type="string", length=255, nullable=true)
     */
    private $aclaracion;

    /**
     * @var string $observaciones
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var string $envia
     *
     * @ORM\Column(name="envia", type="string", length=255, nullable=true)
     */
    private $envia;
    
    /**
     * @var string $ctacte
     *
     * @ORM\Column(name="ctacte", type="boolean", nullable=true)
     */
    private $ctacte;
    
    /**
     * @ORM\OneToMany(targetEntity="Consumo", mappedBy="remitovolvo", cascade={"persist"})
     * @var type 
     */
    private $consumos;
    
    /**
     * @ORM\OneToMany(targetEntity="Renaultconsumo", mappedBy="remitovolvo", cascade={"persist"})
     * @var type 
     */
    private $consumosrenault;
    
    /**
     * @ORM\OneToMany(targetEntity="Pdcconsumo", mappedBy="remitovolvo", cascade={"persist"})
     * @var type 
     */
    private $consumospdc;
    
    public function __construct()
    {        
        $this->consumos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consumosrenault = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consumospdc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fecha =  new \DateTime();
    }


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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Remitovolvo
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set cliente
     *
     * @param string $cliente
     * @return Remitovolvo
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    
        return $this;
    }

    /**
     * Get cliente
     *
     * @return string 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set chasis
     *
     * @param string $chasis
     * @return Remitovolvo
     */
    public function setChasis($chasis)
    {
        $this->chasis = $chasis;
    
        return $this;
    }

    /**
     * Get chasis
     *
     * @return string 
     */
    public function getChasis()
    {
        return $this->chasis;
    }

    /**
     * Set cotizacion
     *
     * @param string $cotizacion
     * @return Remitovolvo
     */
    public function setCotizacion($cotizacion)
    {
        $this->cotizacion = $cotizacion;
    
        return $this;
    }

    /**
     * Get cotizacion
     *
     * @return string 
     */
    public function getCotizacion()
    {
        return $this->cotizacion;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return Remitovolvo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    
        return $this;
    }

    /**
     * Get modelo
     *
     * @return string 
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set dominio
     *
     * @param string $dominio
     * @return Remitovolvo
     */
    public function setDominio($dominio)
    {
        $this->dominio = $dominio;
    
        return $this;
    }

    /**
     * Get dominio
     *
     * @return string 
     */
    public function getDominio()
    {
        return $this->dominio;
    }

    /**
     * Set aclaracion
     *
     * @param string $aclaracion
     * @return Remitovolvo
     */
    public function setAclaracion($aclaracion)
    {
        $this->aclaracion = $aclaracion;
    
        return $this;
    }

    /**
     * Get aclaracion
     *
     * @return string 
     */
    public function getAclaracion()
    {
        return $this->aclaracion;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Remitovolvo
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set envia
     *
     * @param string $envia
     * @return Remitovolvo
     */
    public function setEnvia($envia)
    {
        $this->envia = $envia;
    
        return $this;
    }

    /**
     * Get envia
     *
     * @return string 
     */
    public function getEnvia()
    {
        return $this->envia;
    }
    
    /**
     * Set neto
     *
     * @param string $neto
     * @return Remitovolvo
     */
    public function setNeto($neto)
    {
        $this->neto = $neto;
    
        return $this;
    }

    /**
     * Get neto
     *
     * @return string 
     */
    public function getNeto()
    {
        return $this->neto;
    }
    
    /**
     * Get Consumos
     * 
     * @return type 
     */
    public function getConsumos()
    {
        return $this->consumos;
    }
 
    /**
     * Set Consumos
     * 
     * @param ArrayCollection $consumos 
     */
    public function setConsumos(ArrayCollection $consumos)
    {
        $this->consumos = $consumos;
    }
 
    /**
     * Add consumos
     *
     * @param Sistema\AdminBundle\Entity\Consumo $consumos
     */
    public function addConsumos(\Sistema\AdminBundle\Entity\Consumo $consumos)
    {
        $this->consumos[] = $consumos;
        $consumos->setRemitovolvo($this);
    }
    
     /**
     * Get ConsumosRenault
     * 
     * @return type 
     */
    public function getConsumosRenault()
    {
        return $this->consumosrenault;
    }
 
    /**
     * Set ConsumosRenault
     * 
     * @param ArrayCollection $consumosrenault 
     */
    public function setConsumosRenault(ArrayCollection $consumosrenault)
    {
        $this->consumosrenault = $consumosrenault;
    }
    
    /**
     * Add consumos
     *
     * @param Sistema\AdminBundle\Entity\Renaultconsumo $consumos
     */
    public function addConsumosRenault(\Sistema\AdminBundle\Entity\Renaultconsumo $consumos)
    {
        $this->consumosrenault[] = $consumos;
        $consumos->setRemitovolvo($this);
    }
    
    /**
     * Set ctacte
     *
     * @param string $ctacte
     * @return Remitovolvo
     */
    public function setCtacte($ctacte)
    {
        $this->ctacte = $ctacte;
    
        return $this;
    }

    /**
     * Get ctacte
     *
     * @return string 
     */
    public function getCtacte()
    {
        return $this->ctacte;
    }
    
    /**
     * Get ConsumosPdc
     * 
     * @return type 
     */
    public function getConsumosPdc()
    {
        return $this->consumospdc;
    }
 
    /**
     * Set ConsumosPdc
     * 
     * @param ArrayCollection $consumospdc 
     */
    public function setConsumosPdc(ArrayCollection $consumospdc)
    {
        $this->consumospdc = $consumospdc;
    }
    
    /**
     * Add consumos
     *
     * @param Sistema\AdminBundle\Entity\Pdcconsumo $consumos
     */
    public function addConsumosPdc(\Sistema\AdminBundle\Entity\Pdcconsumo $consumos)
    {
        $this->consumospdc[] = $consumos;
        $consumos->setRemitovolvo($this);
    }
}
