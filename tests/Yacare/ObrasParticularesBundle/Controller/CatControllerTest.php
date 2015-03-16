<?php
namespace Yacare\ObrasParticularesBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba de CatController.
 * 
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 */

class CatControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
	public function setup()
	{
		parent::setup();
		$this->item = new CatController();
	}
	
	public function testConstructor()
	{
		$this->assertEquals('Yacare', $this->item->getVendorName());
		$this->assertEquals('ObrasParticulares', $this->item->getBundleName());
		$this->assertEquals('Cat', $this->item->getEntityName());
	}
	
	public function testBaseRoute()
	{
		$this->assertEquals('yacare_obrasparticulares_cat', $this->item->obtenerRutaBase());
		$this->assertEquals('yacare_obrasparticulares_cat_listar', $this->item->obtenerRutaBase('listar'));
	}
}