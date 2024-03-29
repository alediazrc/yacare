<?php
namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Prueba para el controlador de PersonaGrupo.
 *
 * @author Ernesto Carrea <ernestocarra@gmail.com>
 *
 * @see \Yacare\BaseBundle\Controller\PersonaGrupoController PersonaGrupoController
 */
class PersonaGrupoControllerTest extends \Tapir\BaseBundle\Controller\AbmControllerTest
{
    public function setUp()
    {
        parent::setUp();
        
        $this->item = new PersonaGrupoController();
    }

    public function testCrear()
    {
        $crawler = $this->clientRequestAction('editar_1');
        
        $this->assertTrue($this->client->getResponse()->isSuccessful(), 'Probando que la página de crear sea accesible');
        
        $form = $crawler->selectButton('Guardar')->form();
        
        // set some values
        $form['yacare_basebundle_personagrupotype[Nombre]'] = 'Grupo de pruebas';
        
        // submit the form
        $crawler = $this->client->submit($form);
        
        $this->assertTrue($this->client->getResponse()->isRedirect('/base/personagrupo/listar/?arrastre%5Bd%5D='), 
            'Verificando redirección');
        $this->client->followRedirect();
        
        $this->assertFalse($this->clientTestResponse($crawler));
    }

    /**
     * @depends testCrear
     */
    public function testEditar()
    {
        $crawler = $this->clientRequestAction('editar', array('id' => 1));
        
        $this->assertTrue($this->client->getResponse()->isSuccessful(), 
            'Probando que la página de editar sea accesible');
        
        $form = $crawler->selectButton('Guardar')->form();
        
        // set some values        
        $form['yacare_basebundle_personagrupotype[Nombre]'] = 'Grupo de pruebas modificado ' . date('r');

        // submit the form
        $crawler = $this->client->submit($form);
        
        $this->assertTrue($this->client->getResponse()->isRedirect('/base/personagrupo/listar/?arrastre%5Bd%5D='), 
            'Verificando redirección');
        $this->client->followRedirect();
        
        $this->assertFalse($this->clientTestResponse($crawler));
    }
}
