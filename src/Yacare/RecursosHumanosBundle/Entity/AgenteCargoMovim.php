<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa una novedad o movimiento en un cargo de un agente.
 *
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 *        
 * @ORM\Table(name="Rrhh_AgenteCargoMovim")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class AgenteCargoMovim
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * El agente.
     *
     * @ORM\ManyToOne(targetEntity="Agente", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Agente;

    /**
     * El cargo.
     *
     * @ORM\ManyToOne(targetEntity="Cargo", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $Cargo;

    /**
     * La fecha de la novedad.
     *
     * @ORM\Column(type="date", nullable=false)
     * @Assert\Type("\DateTime")
     */
    private $Fecha;

    /**
     *
     * @ignore
     *
     */
    public function setAgente($Agente)
    {
        return $this->Agente = $Agente;
    }

    /**
     *
     * @ignore
     *
     */
    public function getAgente()
    {
        return $this->Agente;
    }

    /**
     *
     * @ignore
     *
     */
    public function setCargo($Cargo)
    {
        return $this->Cargo = $Cargo;
    }

    /**
     *
     * @ignore
     *
     */
    public function getCargo()
    {
        return $this->Cargo;
    }

    /**
     *
     * @ignore
     *
     */
    public function setFecha($Fecha)
    {
        return $this->Fecha = $Fecha;
    }

    /**
     *
     * @ignore
     *
     */
    public function getFecha()
    {
        return $this->Fecha;
    }
}