<?php
namespace Yacare\BaseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Agrega la capacidad de recuperar una imágen adjunta, para un entidad en concreto.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait ConImagen
{
    /**
     * @Route("imagen/")
     */
    public function imagenAction()
    {
        $id = $this->ObtenerVariable($request, 'id');
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

        if (! $entity) {
            throw $this->createNotFoundException('No se puede cargar la entidad.');
        }

        $imagen_contenido = stream_get_contents($entity->getImagen());

        $response = new \Symfony\Component\HttpFoundation\Response($imagen_contenido, 200, array(
            'Content-Type' => 'image/png',
            'Content-Length' => strlen($imagen_contenido),
            'Content-Disposition' => 'filename="' . 'Yacare' . $this->BundleName . 'Bundle_' . $this->EntityName .
                 '_' . $entity->getId() . '.png"'));

        return $response;
    }
}
