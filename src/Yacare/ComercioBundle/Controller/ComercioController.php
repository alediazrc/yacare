<?php
namespace Yacare\ComercioBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Yacare\ComercioBundle\Entity\Actividad;

/**
 * Controlador de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @Route("comercio/")
 */
class ComercioController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConBuscar;

    /**
     * @Route("altamanual/")
     * @Template()
     */
    function altamanualAction(Request $request)
    {
        return $this->ArrastrarVariables($request);
    }

    /**
     * @see \Tapir\BaseBundle\Controller\AbmController::guardarActionPrePersist() AbmController::guardarActionPrePersist()
     */
    public function guardarActionPrePersist($entity, $editForm)
    {
        self::ReordenarActividades($entity);
        
        parent::guardarActionPrePersist($entity, $editForm);
    }

    /**
     * Reordena las actividades antes de persistirlas en un comercio para que estén consolidadas (sin espacios
     * intermedios en blanco).
     * 
     * @param  \Yacare\ComercioBundle\Entity\Comercio $entity el comercio.
     * @return ComercioController::ReordenarActividades() | null
     */
    public static function ReordenarActividades($entity)
    {
        $Reordenado = false;
        
        if ($entity->getActividad6() && ! $entity->getActividad5()) {
            $entity->setActividad5($entity->getActividad6());
            $entity->setActividad6(null);
            $Reordenado = true;
        }
        
        if ($entity->getActividad5() && ! $entity->getActividad4()) {
            $entity->setActividad4($entity->getActividad5());
            $entity->setActividad5(null);
            $Reordenado = true;
        }
        
        if ($entity->getActividad4() && ! $entity->getActividad3()) {
            $entity->setActividad3($entity->getActividad4());
            $entity->setActividad4(null);
            $Reordenado = true;
        }
        
        if ($entity->getActividad3() && ! $entity->getActividad2()) {
            $entity->setActividad2($entity->getActividad3());
            $entity->setActividad3(null);
            $Reordenado = true;
        }
        
        if ($Reordenado) {
            // Si hice cambios, uso recursión para hacer una pasada más, que puede ser necesaria.
            return self::ReordenarActividades($entity);
        } else {
            // No hice cambios. La lista está ordenada.
            return;
        }
    }
}
