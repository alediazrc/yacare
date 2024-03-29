<?php
namespace Yacare\RecursosHumanosBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de AgenteGrupo.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * 
 * @see \Yacare\RecursosHumanosBundle\Controller\AgenteGrupoController AgenteGrupoController
 */
class AgenteGrupoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setup()
    {
        parent::setup();
        $this->item = new AgenteGrupoController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Yacare', $this->item->getVendorName());
        $this->assertEquals('RecursosHumanos', $this->item->getBundleName());
        $this->assertEquals('AgenteGrupo', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('yacare_recursoshumanos_agentegrupo', $this->item->obtenerRutaBase());
        $this->assertEquals('yacare_recursoshumanos_agentegrupo_listar', $this->item->obtenerRutaBase('listar'));
    }
}
