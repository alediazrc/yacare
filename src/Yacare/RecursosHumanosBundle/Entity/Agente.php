<?php

namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\RecursosHumanosBundle\Entity\Agente
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Agente extends Yacare\BaseBundle\Entity\Persona
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
     * @var integer $Legajo
     *
     * @ORM\Column(name="Legajo", type="integer")
     */
    private $Legajo;

    /**
     * @var \DateTime $FechaIngreso
     *
     * @ORM\Column(name="FechaIngreso", type="datetime")
     */
    private $FechaIngreso;


    /**
     * Set Legajo
     *
     * @param integer $legajo
     * @return Agente
     */
    public function setLegajo($legajo)
    {
        $this->Legajo = $legajo;
    
        return $this;
    }

    /**
     * Get Legajo
     *
     * @return integer 
     */
    public function getLegajo()
    {
        return $this->Legajo;
    }

    /**
     * Set FechaIngreso
     *
     * @param \DateTime $fechaIngreso
     * @return Agente
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->FechaIngreso = $fechaIngreso;
    
        return $this;
    }

    /**
     * Get FechaIngreso
     *
     * @return \DateTime 
     */
    public function getFechaIngreso()
    {
        return $this->FechaIngreso;
    }
}
