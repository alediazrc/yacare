<?php

namespace Yacare\InicioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class InicioController extends Controller
{
    /**
     * @Route("/", name="inicio")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }
}