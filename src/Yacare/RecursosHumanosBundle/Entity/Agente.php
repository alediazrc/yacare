<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Representa un agente (empleado).
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *        
 * @ORM\Table(name="Rrhh_Agente", uniqueConstraints={@ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})})
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Agente
{
    use\Tapir\BaseBundle\Entity\ConId;
    use\Tapir\BaseBundle\Entity\Versionable;
    use\Tapir\BaseBundle\Entity\Suprimible;
    use\Tapir\BaseBundle\Entity\Importable;
    use\Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /*
     * CREATE VIEW rr_hh_agentes AS SELECT * FROM rr_hh.agentes; CREATE OR REPLACE VIEW yacare.Rrhh_Agente AS SELECT agentes.legajo AS id, agentes.fechaingre AS FechaIngreso, agentes.nombre AS NombreVisible, agentes.username, agentes.salt, agentes.password, agentes.is_active, agentes.NombreSolo as Nombre, agentes.Apellido, agentes.email FROM rr_hh.agentes; ALTER TABLE rr_hh.agentes ADD username VARCHAR(25) NOT NULL DEFAULT '', ADD salt VARCHAR(32) NOT NULL DEFAULT '', ADD password VARCHAR(40) NOT NULL DEFAULT '', ADD NombreSolo VARCHAR(255) NOT NULL DEFAULT '', ADD Apellido VARCHAR(255) NOT NULL DEFAULT '', CHANGE fechaingre fechaingre DATE NOT NULL, CHANGE nombre nombre VARCHAR(255) NOT NULL DEFAULT '', CHANGE email email VARCHAR(255) NOT NULL DEFAULT ''; UPDATE yacare.Rrhh_Agente SET salt=MD5(RAND()) WHERE salt=''; UPDATE rr_hh.agentes SET Apellido=TRIM(SUBSTRING_INDEX(nombre, ' ', 1)) WHERE NombreSolo=''; UPDATE rr_hh.agentes SET NombreSolo=TRIM(TRIM(LEADING Apellido FROM nombre)) WHERE NombreSolo='';
     */
    
    /**
     * La persona asociada.
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Persona;

    /**
     * La categoría actual.
     *
     * @var $Categoria
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Categoria;

    /**
     * TODO: Verificar el significado de este campo en "Gestion.exe" / con Daniel Camargo.
     *
     * @var $Situacion
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Situacion;

    /**
     * La función que cumple, en formato de texto libre. 
     *
     * @var $Funcion
     * 
     * @ORM\Column(type="string")
     */
    private $Funcion;

    /**
     * La fecha de ingreso.
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaIngreso;

    /**
     * La fecha de baja, o NULL si todavía está activo.
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("\DateTime")
     */
    private $FechaBaja;

    /**
     * El departamento en el cual se desempeña.
     *
     * @var $Departamento
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Departamento;
    

    public function __toString()
    {
        return $this->getPersona()->getNombreVisible();
    }
    
    

    /**
     * @ignore
     */
    public function getPersona()
    {
        return $this->Persona;
    }

    /**
     * @ignore
     */
    public function setPersona($Persona)
    {
        $this->Persona = $Persona;
    }

    /**
     * @ignore
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     * @ignore
     */
    public function setCategoria($Categoria)
    {
        $this->Categoria = $Categoria;
    }

    /**
     * @ignore
     */
    public function getSituacion()
    {
        return $this->Situacion;
    }

    /**
     * @ignore
     */
    public function setSituacion($Situacion)
    {
        $this->Situacion = $Situacion;
    }

    /**
     * @ignore
     */
    public function getFuncion()
    {
        return $this->Funcion;
    }

    /**
     * @ignore
     */
    public function setFuncion($Funcion)
    {
        $this->Funcion = $Funcion;
    }

    /**
     * @ignore
     */
    public function getFechaIngreso()
    {
        return $this->FechaIngreso;
    }

    /**
     * @ignore
     */
    public function setFechaIngreso(\DateTime $FechaIngreso = null)
    {
        $this->FechaIngreso = $FechaIngreso;
    }

    /**
     * @ignore
     */
    public function getFechaBaja()
    {
        return $this->FechaBaja;
    }

    /**
     * @ignore
     */
    public function setFechaBaja(\DateTime $FechaBaja = null)
    {
        $this->FechaBaja = $FechaBaja;
    }

    /**
     * @ignore
     */
    public function getDepartamento()
    {
        return $this->Departamento;
    }

    /**
     * @ignore
     */
    public function setDepartamento($Departamento)
    {
        $this->Departamento = $Departamento;
    }
}
