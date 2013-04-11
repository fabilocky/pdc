<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sistema\AdminBundle\Entity\Ordrenault
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Ordrenault
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
     * @var string $cliente
     *
     * @ORM\Column(name="cliente", type="string", length=255)
     */
    private $cliente;

    /**
     * @var string $cuit
     *
     * @ORM\Column(name="cuit", type="string", length=255)
     */
    private $cuit;

    /**
     * @var string $chofer
     *
     * @ORM\Column(name="chofer", type="string", length=255)
     */
    private $chofer;

    /**
     * @var string $telefono
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

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
     * @ORM\Column(name="km", type="float")
     */
    private $km;

    /**
     * @var float $hs
     *
     * @ORM\Column(name="hs", type="float")
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
     * @ORM\OneToMany(targetEntity="Solicrep", mappedBy="ordrenault", cascade={"persist"})
     * @var type 
     */
    private $solicitudes;
    
    /**
     * @ORM\OneToMany(targetEntity="Consumo", mappedBy="ordrenault", cascade={"persist"})
     * @var type 
     */
    private $consumos;
    
     /**
     * @ORM\OneToMany(targetEntity="Operaciones", mappedBy="ordrenault", cascade={"persist"})
     * @var type 
     */
    private $operaciones;
    
    /**
     * @ORM\OneToMany(targetEntity="Terceros", mappedBy="ordrenault", cascade={"persist"})
     * @var type 
     */
    private $terceros;

     public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->consumos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Ordrenault
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
     * @param float $cotizacion
     * @return Ordrenault
     */
    public function setCotizacion($cotizacion)
    {
        $this->cotizacion = $cotizacion;
    
        return $this;
    }

    /**
     * Get cotizacion
     *
     * @return float 
     */
    public function getCotizacion()
    {
        return $this->cotizacion;
    }

    /**
     * Set cliente
     *
     * @param string $cliente
     * @return Ordrenault
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
     * Set cuit
     *
     * @param string $cuit
     * @return Ordrenault
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    
        return $this;
    }

    /**
     * Get cuit
     *
     * @return string 
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set chofer
     *
     * @param string $chofer
     * @return Ordrenault
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
     * Set telefono
     *
     * @param string $telefono
     * @return Ordrenault
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    
        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set chasis
     *
     * @param string $chasis
     * @return Ordrenault
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
     * @return Ordrenault
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
     * @return Ordrenault
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
     * @return Ordrenault
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
     * @return Ordrenault
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
     * @return Ordrenault
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
     * @param float $neto
     * @return Ordrenault
     */
    public function setNeto($neto)
    {
        $this->neto = $neto;
    
        return $this;
    }

    /**
     * Get neto
     *
     * @return float 
     */
    public function getNeto()
    {
        return $this->neto;
    }

    /**
     * Set iva
     *
     * @param float $iva
     * @return Ordrenault
     */
    public function setIva($iva)
    {
        $this->iva = $iva;
    
        return $this;
    }

    /**
     * Get iva
     *
     * @return float 
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Ordrenault
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }
    
    /**
     * Get Solicitudes
     * 
     * @return type 
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
     * Add solicitudes
     *
     * @param Sistema\AdminBundle\Entity\Solicrep $solicitudes
     */
    public function addSolicitudes(\Sistema\AdminBundle\Entity\Solicrep $solicitudes)
    {
        $this->solicitudes[] = $solicitudes;
        $solicitudes->setOrdrenault($this);
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
    public function addConsumos(\Sistema\AdminBundle\Entity\Consumo $consumos, \Sistema\AdminBundle\Entity\Remitorenault $remitorenault)
    {
        $this->consumos[] = $consumos;
        $consumos->setOrdrenault($this);
        $consumos->setRemitorenault($remitorenault);
    }
    
    /**
     * Get Operaciones
     * 
     * @return type 
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
     * Add operaciones
     *
     * @param Sistema\AdminBundle\Entity\Operaciones $operaciones
     */
    public function addOperaciones(\Sistema\AdminBundle\Entity\Operaciones $operaciones)
    {
        $this->operaciones[] = $operaciones;
        $operaciones->setOrdrenault($this);
    }
    
    /**
     * Get Terceros
     * 
     * @return type 
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
     * Add terceros
     *
     * @param Sistema\AdminBundle\Entity\Terceros $terceros
     */
    public function addTerceros(\Sistema\AdminBundle\Entity\Terceros $terceros)
    {
        $this->terceros[] = $terceros;
        $terceros->setOrdrenault($this);
    }    
    
}
