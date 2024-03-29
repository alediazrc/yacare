<?php
namespace Yacare\InspeccionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipo de acta (representa una especie).
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Inspeccion_ActaTipo")
 */
class ActaTipo
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * Indica el departamento o dependencia a la cual pertenecen este tipo de actas.
     *
     * @see \Yacare\BaseBundle\Organizacion\Departamento Departamento
     * 
     * @ORM\ManyToOne(targetEntity="Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Departamento;

    /**
     * El nombre de la clase (derivada de Acta) con la cual instanciar las actas de este tipo.
     *
     * @var string 
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Clase;

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

    /**
     * @ignore
     */
    public function getClase()
    {
        return $this->Clase;
    }

    /**
     * @ignore
     */
    public function setClase($Clase)
    {
        $this->Clase = $Clase;
    }
}
