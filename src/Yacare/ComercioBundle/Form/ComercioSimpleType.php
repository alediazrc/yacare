<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario simple para un comercio.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ComercioSimpleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Nombre', null, array(
                'label' => 'Nombre de fantasía'))
            ->add('ExpedienteNumero', new \Yacare\AdministracionBundle\Form\Type\ExpedienteType(), array(
                'label' => 'Expediente',
                'required' => false))
            ->add('Apoderado', new \Yacare\BaseBundle\Form\Type\PersonaType(), array(
                'label' => 'Apoderado',
                'placeholder' => 'Apoderado',
                'required' => false))
            ->add('Local', new \Yacare\ComercioBundle\Form\Type\LocalType(), array(
                'label' => 'Local',
                'required' => false))
            ->add('Actividad1', 'entity_id', array(
                'label' => 'Actividad 1',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => true))
            ->add('Actividad2', 'entity_id', array(
                'label' => 'Actividad 2',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad3', 'entity_id', array(
                'label' => 'Actividad 3',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad4', 'entity_id', array(
                'label' => 'Actividad 4',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad5', 'entity_id', array(
                'label' => 'Actividad 5',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false))
            ->add('Actividad6', 'entity_id', array(
                'label' => 'Actividad 6',
                'class' => 'Yacare\ComercioBundle\Entity\Actividad',
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Comercio'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_comerciosimpletype';
    }
}
