<?php
namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\Instrumento
 *
 * @ORM\Table(name="Tramites_Instrumento")
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 */
class Instrumento
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     *
     * @var string @ORM\Column(type="string", length=50)
     */
    private $Codigo;

    /**
     *
     * @var string @ORM\Column(type="string", length=50)
     */
    private $Tipo;

    public function getTipoNombre()
    {
        switch ($this->Tipo) {
            case 'com':
                return 'Comprobante';
            case 'for':
                return 'Formulario';
            case 'ins':
                return 'Instructivo';
            case 'car':
                return 'Carpeta';
            default:
                return '???';
        }
    }

    public function getCodigo()
    {
        return $this->Codigo;
    }

    public function setCodigo($Codigo)
    {
        $this->Codigo = $Codigo;
    }

    public function getTipo()
    {
        return $this->Tipo;
    }

    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
    }
}
