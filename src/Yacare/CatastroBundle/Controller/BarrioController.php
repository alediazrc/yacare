<?php
namespace Yacare\CatastroBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("barrio/")
 */
class BarrioController extends \Tapir\BaseBundle\Controller\AbmController
{
    use\Yacare\BaseBundle\Controller\ConExportarLista;
}
