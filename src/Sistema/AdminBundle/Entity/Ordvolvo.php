<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sistema\AdminBundle\Entity\Ordvolvo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Ordvolvo
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
     * @var string $cotizacion
     *
     * @ORM\Column(name="cotizacion", type="string")
     */
    private $cotizacion;

    /**
     * @var Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cliente", referencedColumnName="id")
     * })
     */
    private $cliente;    

    /**
     * @var string $chofer
     *
     * @ORM\Column(name="chofer", type="string", length=255)
     */
    private $chofer;    

    /**
     * @var string $chasis
     *
     * @ORM\Column(name="chasis", type="string", length=255)
     */
    private $chasis;

    /**
     * @var string $modelo
     *
     * @ORM\Column(name="modelo", type="string", length=255)
     */
    private $modelo;

    /**
     * @var string $dominio
     *
     * @ORM\Column(name="dominio", type="string", length=255)
     */
    private $dominio;

    /**
     * @var float $km
     *
     * @ORM\Column(name="km", type="float", nullable=true)
     */
    private $km;

    /**
     * @var float $hs
     *
     * @ORM\Column(name="hs", type="float", nullable=true)
     */
    private $hs;

    /**
     * @var string $color
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * @var string $neto
     *
     * @ORM\Column(name="neto", type="string")
     */
    private $neto;

    /**
     * @var string $iva
     *
     * @ORM\Column(name="iva", type="string")
     */
    private $iva;

    /**
     * @var string $total
     *
     * @ORM\Column(name="total", type="string")
     */
    private $total;
    
    /**
     * @ORM\OneToMany(targetEntity="Solicrep", mappedBy="ordvolvo", cascade={"all"})
     * @var type 
     */
    private $solicitudes;
    
    /**
     * @ORM\OneToMany(targetEntity="Consumo", mappedBy="ordvolvo", cascade={"all"})
     * @var type 
     */
    private $consumos;
    
    /**
     * @ORM\OneToMany(targetEntity="Otro", mappedBy="ordvolvo", cascade={"all"})
     * @var type 
     */
    private $otro;
    
     /**
     * @ORM\OneToMany(targetEntity="Operaciones", mappedBy="ordvolvo", cascade={"all"})
     * @var type 
     */
    private $operaciones;
    
    /**
     * @ORM\OneToMany(targetEntity="Terceros", mappedBy="ordvolvo", cascade={"all"})
     * @var type 
     */
    private $terceros;

     public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consumos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->otro = new \Doctrine\Common\Collections\ArrayCollection();
        $this->operaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->terceros = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Ordvolvo
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
     * Set cotizacion
     *
     * @param string $cotizacion
     * @return Ordvolvo
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
     * Set chofer
     *
     * @param string $chofer
     * @return Ordvolvo
     */
    public function setChofer($chofer)
    {
        $this->chofer = $chofer;
    
        return $this;
    }

    /**
     * Get chofer
     *
     * @return string 
     */
    public function getChofer()
    {
        return $this->chofer;
    }

    /**
     * Set chasis
     *
     * @param string $chasis
     * @return Ordvolvo
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
     * Set modelo
     *
     * @param string $modelo
     * @return Ordvolvo
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
     * @return Ordvolvo
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
     * Set km
     *
     * @param float $km
     * @return Ordvolvo
     */
    public function setKm($km)
    {
        $this->km = $km;
    
        return $this;
    }

    /**
     * Get km
     *
     * @return float 
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Set hs
     *
     * @param float $hs
     * @return Ordvolvo
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
     * Set color
     *
     * @param string $color
     * @return Ordvolvo
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set neto
     *
     * @param string $neto
     * @return Ordvolvo
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
     * Set iva
     *
     * @param string $iva
     * @return Ordvolvo
     */
    public function setIva($iva)
    {
        $this->iva = $iva;
    
        return $this;
    }

    /**
     * Get iva
     *
     * @return string 
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return Ordvolvo
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return string 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set cliente
     *
     * @param Sistema\AdminBundle\Entity\Cliente $cliente
     * @return Ordvolvo
     */
    public function setCliente(\Sistema\AdminBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;
    
        return $this;
    }

    /**
     * Get cliente
     *
     * @return Sistema\AdminBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Add solicitudes
     *
     * @param Sistema\AdminBundle\Entity\Solicrep $solicitudes
     * @return Ordvolvo
     */
    public function addSolicitudes(\Sistema\AdminBundle\Entity\Solicrep $solicitudes)
    {
        $this->solicitudes[] = $solicitudes;
        $solicitudes->setOrdvolvo($this);
    }

    /**
     * Remove solicitudes
     *
     * @param Sistema\AdminBundle\Entity\Solicrep $solicitudes
     */
    public function removeSolicitudes(\Sistema\AdminBundle\Entity\Solicrep $solicitudes)
    {
        $this->solicitudes->removeElement($solicitudes);
    }

    /**
     * Get solicitudes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSolicitudes()
    {
        return $this->solicitudes;
    }
    
    /**
     * Set Solicitudes
     * 
     * @param ArrayCollection $solicitudes
     */
    public function setSolicitudes(ArrayCollection $solicitudes)
    {
        $this->solicitudes = $solicitudes;
    }

    /**
     * Add consumos
     *
     * @param Sistema\AdminBundle\Entity\Consumo $consumos
     * @return Ordvolvo
     */
    public function addConsumos(\Sistema\AdminBundle\Entity\Consumo $consumos)
    {
        $this->consumos[] = $consumos;
        $consumos->setOrdvolvo($this);
        
    }

    /**
     * Remove consumos
     *
     * @param Sistema\AdminBundle\Entity\Consumo $consumos
     */
    public function removeConsumos(\Sistema\AdminBundle\Entity\Consumo $consumos)
    {
        $this->consumos->removeElement($consumos);
    }

    /**
     * Get consumos
     *
     * @return Doctrine\Common\Collections\Collection 
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
     * Add operaciones
     *
     * @param Sistema\AdminBundle\Entity\Operaciones $operaciones
     * @return Ordvolvo
     */
    public function addOperaciones(\Sistema\AdminBundle\Entity\Operaciones $operaciones)
    {
        $this->operaciones[] = $operaciones;
        $operaciones->setOrdvolvo($this);
    }

    /**
     * Remove operaciones
     *
     * @param Sistema\AdminBundle\Entity\Operaciones $operaciones
     */
    public function removeOperaciones(\Sistema\AdminBundle\Entity\Operaciones $operaciones)
    {
        $this->operaciones->removeElement($operaciones);
    }

    /**
     * Get operaciones
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOperaciones()
    {
        return $this->operaciones;
    }
    
    /**
     * Set Operaciones
     * 
     * @param ArrayCollection $operaciones
     */
    public function setOperaciones(ArrayCollection $operaciones)
    {
        $this->operaciones = $operaciones;
    }

    /**
     * Add terceros
     *
     * @param Sistema\AdminBundle\Entity\Terceros $terceros
     * @return Ordvolvo
     */
    public function addTerceros(\Sistema\AdminBundle\Entity\Terceros $terceros)
    {
        $this->terceros[] = $terceros;
        $terceros->setOrdvolvo($this);
    }

    /**
     * Remove terceros
     *
     * @param Sistema\AdminBundle\Entity\Terceros $terceros
     */
    public function removeTerceros(\Sistema\AdminBundle\Entity\Terceros $terceros)
    {
        $this->terceros->removeElement($terceros);
    }

    /**
     * Get terceros
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTerceros()
    {
        return $this->terceros;
    }
    
    /**
     * Set Terceros
     * 
     * @param ArrayCollection $terceros
     */
    public function setTerceros(ArrayCollection $terceros)
    {
        $this->terceros = $terceros;
    }
    
    /**
     * Add otro
     *
     * @param Sistema\AdminBundle\Entity\Otro $otro
     * @return Ordvolvo
     */
    public function addOtro(\Sistema\AdminBundle\Entity\Otro $otro)
    {
        $this->otro[] = $otro;
        $otro->setOrdvolvo($this);
    }

    /**
     * Remove otro
     *
     * @param Sistema\AdminBundle\Entity\Otro $otro
     */
    public function removeOtro(\Sistema\AdminBundle\Entity\Otro $otro)
    {
        $this->otro->removeElement($otro);
    }

    /**
     * Get otro
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOtro()
    {
        return $this->otro;
    }
    
    /**
     * Set Otro
     * 
     * @param ArrayCollection $otro
     */
    public function setOtro(ArrayCollection $otro)
    {
        $this->otro = $otro;
    }
}