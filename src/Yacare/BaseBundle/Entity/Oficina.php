<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\Oficina
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Oficina extends Yacare\BaseBundle\Entity\EndidadBase
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
     * @var string $Nombre
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $Nombre;

    /**
     * @var integer $Dependencia
     *
     * @ORM\Column(name="Dependencia", type="integer")
     */
    private $Dependencia;

    /**
     * @var integer $Edificio
     *
     * @ORM\Column(name="Edificio", type="integer")
     */
    private $Edificio;

    /**
     * @var boolean $Principal
     *
     * @ORM\Column(name="Principal", type="boolean")
     */
    private $Principal;


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
     * Set Nombre
     *
     * @param string $nombre
     * @return Oficina
     */
    public function setNombre($nombre)
    {
        $this->Nombre = $nombre;
    
        return $this;
    }

    /**
     * Get Nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * Set Dependencia
     *
     * @param integer $dependencia
     * @return Oficina
     */
    public function setDependencia($dependencia)
    {
        $this->Dependencia = $dependencia;
    
        return $this;
    }

    /**
     * Get Dependencia
     *
     * @return integer 
     */
    public function getDependencia()
    {
        return $this->Dependencia;
    }

    /**
     * Set Edificio
     *
     * @param integer $edificio
     * @return Oficina
     */
    public function setEdificio($edificio)
    {
        $this->Edificio = $edificio;
    
        return $this;
    }

    /**
     * Get Edificio
     *
     * @return integer 
     */
    public function getEdificio()
    {
        return $this->Edificio;
    }

    /**
     * Set Principal
     *
     * @param boolean $principal
     * @return Oficina
     */
    public function setPrincipal($principal)
    {
        $this->Principal = $principal;
    
        return $this;
    }

    /**
     * Get Principal
     *
     * @return boolean 
     */
    public function getPrincipal()
    {
        return $this->Principal;
    }
}
