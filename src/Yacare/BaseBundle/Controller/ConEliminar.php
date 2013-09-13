<?php

namespace Yacare\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

trait ConEliminar {

    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("eliminar/{id}")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template("YacareBaseBundle:Default:eliminar.html.twig")
     */
    public function eliminarAction($id)
    {
        $deleteForm = $this->createDeleteForm($id);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se puede encontrar la entidad.');
        }

        return $this->ArrastrarVariables(array(
            'entity'      => $entity,
            'create'      => $id ? false : true,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    
    /**
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("eliminar2/{id}")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Method("POST")
     * @Sensio\Bundle\FrameworkExtraBundle\Configuration\Template("YacareBaseBundle:Default:eliminar2.html.twig")
     */
    public function eliminar2Action(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Yacare' . $this->BundleName . 'Bundle:' . $this->EntityName)->find($id);

            if(in_array('Yacare\BaseBundle\Entity\Suprimible', class_uses($entity))) {
                // Es suprimible (soft-deletable), lo marco como borrado, pero no lo borro
                $entity->Suprimir();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Se suprimió el elemento "' . $entity . '".');
            } else if(in_array('Yacare\BaseBundle\Entity\Eliminable', class_uses($entity))) {
                // Es eliminable... lo elimino de verdad
                $em->remove($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Se eliminó el elemento "' . $entity . '".');
            } else {
                // No es eliminable ni suprimible... no se puede borrar
                $this->get('session')->getFlashBag()->add('notice', 'No se puede eliminar el elemento "' . $entity . '".');
            }
        }

        return $this->redirect($this->generateUrl($this->getBaseRoute('listar'), $this->ArrastrarVariables(null, false)));
    }
}