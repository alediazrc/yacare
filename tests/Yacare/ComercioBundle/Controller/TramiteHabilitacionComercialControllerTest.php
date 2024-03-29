<?php
namespace Yacare\ComercioBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de TramiteHabilitacionComercial.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\ComercioBundle\Controller\TramiteHabilitacionComercialController TramiteHabilitacionComercialController
 */
class TramiteHabilitacionComercialControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new TramiteHabilitacionComercialController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('Comercio', $this->item->getBundleName());
        $this->assertEquals('TramiteHabilitacionComercial', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_comercio_tramitehabilitacioncomercial', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_comercio_tramitehabilitacioncomercial_listar', 
            $this->item->obtenerRutaBase('listar'));
    }
}
