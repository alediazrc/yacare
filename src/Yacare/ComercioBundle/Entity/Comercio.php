<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * El comercio.
 *
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Comercio_Comercio")
 */
class Comercio
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConNombre;
    use \Yacare\ComercioBundle\Entity\ConDatosComercio;    
    use \Yacare\AdministracionBundle\Entity\ConExpediente;
    use \Yacare\AdministracionBundle\Entity\ConActoAdministrativo;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Yacare\TramitesBundle\Entity\ConTitular;
    use \Yacare\TramitesBundle\Entity\ConApoderado;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $Estado = 0;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\CertificadoHabilitacionComercial")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $CertificadoHabilitacion;

    /**
     * Normaliza nombres de estado.
     * 
     * @param integer $estado
     */
    public static function NombreEstado($estado)
    {
        switch ($estado) {
            case 0:
                return 'No habilitado';
            case 1:
                return 'En trámite';
            case 90:
                return 'Cerrado';
            case 91:
                return 'Hab. vencida';
            case 100:
                return 'Habilitado';
            default:
                return '???';
        }
    }

    public function getEstadoNombre()
    {
        return self::NombreEstado($this->Estado);
    }

    /**
     * @ignore
     */
    public function getEstado()
    {
        return $this->Estado;
    }

    /**
     * @ignore
     */
    public function setEstado($Estado)
    {
        $this->Estado = $Estado;
    }

    /**
     * @ignore
     */
    public function getCertificadoHabilitacion()
    {
        return $this->CertificadoHabilitacion;
    }

    /**
     * @ignore
     */
    public function setCertificadoHabilitacion($CertificadoHabilitacion)
    {
        $this->CertificadoHabilitacion = $CertificadoHabilitacion;
    }
}
