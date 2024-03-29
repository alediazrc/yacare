<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador de grupos de personas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @Route("personagrupo/")
 */
class PersonaGrupoController extends \Tapir\BaseBundle\Controller\AbmController
{
    use \Tapir\BaseBundle\Controller\ConEliminar;

    function IniciarVariables()
    {
        parent::IniciarVariables();
        $this->EntityLabel = 'Grupo (personas)';
    }
}
