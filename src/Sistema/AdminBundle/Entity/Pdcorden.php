<?php

namespace Sistema\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Sistema\AdminBundle\Entity\Pdcorden
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Pdcorden
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
     * @var string $cam
     *
     * @ORM\Column(name="cam", type="string", length=255, nullable=true)
     */
    private $cam;
    
    /**
     * @var \DateTime $fechafab
     *
     * @ORM\Column(name="fechafab", type="date", nullable=true)
     */
    private $fechafab;

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
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
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
     * @var Repvolvo
     *
     * @ORM\OneToOne(targetEntity="Remitovolvo", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_remitovolvo", referencedColumnName="id")
     * })
     */
    private $idRemito;
    
    /**
     * @ORM\OneToMany(targetEntity="Pdcsolicrep", mappedBy="pdcorden", cascade={"persist"})
     * @var type 
     */
    private $solicitudes;
    
    /**
     * @ORM\OneToMany(targetEntity="Pdcconsumo", mappedBy="pdcorden", cascade={"persist"})
     * @var type 
     */
    private $consumos;
    
     /**
     * @ORM\OneToMany(targetEntity="Pdcoperaciones", mappedBy="pdcorden", cascade={"persist"})
     * @var type 
     */
    private $operaciones;
    
    /**
     * @ORM\OneToMany(targetEntity="Pdcterceros", mappedBy="pdcorden", cascade={"persist"})
     * @var type 
     */
    private $terceros;
    
    /**
     * @ORM\OneToMany(targetEntity="Otro", mappedBy="pdcorden", cascade={"persist"})
     * @var type 
     */
    private $otro;

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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @return Pdcorden
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
     * @param Sistema\AdminBundle\Entity\Pdcsolicrep $solicitudes
     * @return Pdcorden
     */
    public function addSolicitudes(\Sistema\AdminBundle\Entity\Pdcsolicrep $solicitudes)
    {
        $this->solicitudes[] = $solicitudes;
        $solicitudes->setPdcorden($this);
    }

    /**
     * Remove solicitudes
     *
     * @param Sistema\AdminBundle\Entity\Pdcsolicrep $solicitudes
     */
    public function removeSolicitudes(\Sistema\AdminBundle\Entity\Pdcsolicrep $solicitudes)
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
     * @param Sistema\AdminBundle\Entity\Pdcconsumo $consumos
     * @return Pdcorden
     */
    public function addConsumos(\Sistema\AdminBundle\Entity\Pdcconsumo $consumos)
    {
        $this->consumos[] = $consumos;
        $consumos->setPdcorden($this);
        
    }

    /**
     * Remove consumos
     *
     * @param Sistema\AdminBundle\Entity\Pdcconsumo $consumos
     */
    public function removeConsumos(\Sistema\AdminBundle\Entity\Pdcconsumo $consumos)
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
     * @param Sistema\AdminBundle\Entity\Pdcoperaciones $operaciones
     * @return Pdcorden
     */
    public function addOperaciones(\Sistema\AdminBundle\Entity\Pdcoperaciones $operaciones)
    {
        $this->operaciones[] = $operaciones;
        $operaciones->setPdcorden($this);
    }

    /**
     * Remove operaciones
     *
     * @param Sistema\AdminBundle\Entity\Pdcoperaciones $operaciones
     */
    public function removeOperaciones(\Sistema\AdminBundle\Entity\Pdcoperaciones $operaciones)
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
     * @param Sistema\AdminBundle\Entity\Pdcterceros $terceros
     * @return Pdcorden
     */
    public function addTerceros(\Sistema\AdminBundle\Entity\Pdcterceros $terceros)
    {
        $this->terceros[] = $terceros;
        $terceros->setPdcorden($this);
    }

    /**
     * Remove terceros
     *
     * @param Sistema\AdminBundle\Entity\Pdcterceros $terceros
     */
    public function removeTerceros(\Sistema\AdminBundle\Entity\Pdcterceros $terceros)
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
     * Set fechafab
     *
     * @param \DateTime $fechafab
     * @return Pdcorden
     */
    public function setFechafab($fechafab)
    {
        $this->fechafab = $fechafab;
    
        return $this;
    }

    /**
     * Get fechafab
     *
     * @return \DateTime 
     */
    public function getFechafab()
    {
        return $this->fechafab;
    }
    
     /**
     * Set cam
     *
     * @param string $cam
     * @return Pdcorden
     */
    public function setCam($cam)
    {
        $this->cam = $cam;
    
        return $this;
    }

    /**
     * Get cam
     *
     * @return string 
     */
    public function getCam()
    {
        return $this->cam;
    }
    
    /**
     * Set idRemito
     *
     * @param Sistema\AdminBundle\Entity\Remitovolvo $idRemito
     * @return Consumo
     */
    public function setIdRemito(\Sistema\AdminBundle\Entity\Remitovolvo $idRemito = null)
    {
        $this->idRemito = $idRemito;
    
        return $this;
    }

    /**
     * Get idRemito
     *
     * @return Sistema\AdminBundle\Entity\Remitovolvo
     */
    public function getIdRemito()
    {
        return $this->idRemito;
    }
    
    /**
     * Add otro
     *
     * @param Sistema\AdminBundle\Entity\Otro $otro
     * @return Pdcorden
     */
    public function addOtro(\Sistema\AdminBundle\Entity\Otro $otro)
    {
        $this->otro[] = $otro;
        $otro->setPdcorden($this);
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