<?php
namespace Tapir\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de PersonaRol.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * 
 * @see \Tapir\BaseBundle\Controller\PersonaRolController PersonaRolController
 */
class PersonaRolControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new PersonaRolController();
    }

    public function testConstructor()
    {
        $this->assertEquals('Tapir', $this->item->getVendorName());
        $this->assertEquals('Base', $this->item->getBundleName());
        $this->assertEquals('PersonaRol', $this->item->getEntityName());
    }

    public function testBaseRoute()
    {
        $this->assertEquals('tapir_base_personarol', $this->item->obtenerRutaBase());
        $this->assertEquals('tapir_base_personarol_listar', $this->item->obtenerRutaBase('listar'));
    }
}
