<?php
namespace Yacare\TramitesBundle\Controller;

class InstrumentoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{

    public function setUp()
    {
        parent::setUp();
        
        $this->item = new InstrumentoController();
    }
}