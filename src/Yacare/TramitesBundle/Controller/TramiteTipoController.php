<?php
namespace Yacare\TramitesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de tipos de trámite.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see Yacare\TramitesBundle\Entity\TramiteTipo TramiteTipo
 * 
 * @Route("tramitetipo/")
 */
class TramiteTipoController extends \Tapir\BaseBundle\Controller\AbmController
{
    public function guardarActionPrePersist($entity, $editForm)
    {
        // Crear o actualizar un requisito asociado
        $RequisitoEspejo = $entity->getRequisitoEspejo();
        if (! $RequisitoEspejo) {
            $RequisitoEspejo = new \Yacare\TramitesBundle\Entity\Requisito();
        }
        
        $RequisitoEspejo->setTramiteTipoEspejo($entity);
        $RequisitoEspejo->setTipo('tra');
        $RequisitoEspejo->setNombre('(trámite) ' . (string) $entity);
        
        $entity->setRequisitoEspejo($RequisitoEspejo);
        
        parent::guardarActionPrePersist($entity, $editForm);
    }
}
