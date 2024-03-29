<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador predeterminado.
 *
 * Contiene funciones puntuales de página de bienvenida (inicio), login y logout.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class DefaultController extends BaseController
{
    /**
     * @Route("inicio/")
     * @Template
     */
    public function inicioAction()
    {
        return array();
    }
}
