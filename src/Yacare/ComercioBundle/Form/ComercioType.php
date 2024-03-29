<?php
namespace Yacare\ComercioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario con datos adicionales para un comercio.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class ComercioType extends ComercioSimpleType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Titular', new \Yacare\BaseBundle\Form\Type\PersonaType(), array(
                'label' => 'Titular',
                'required' => true))
            ->add('Estado', 'choice', array(
                'label' => 'Estado',
                'required' => true,
                'choices' => array(
                    0 => 'No habilitado',
                    1 => 'Habilitación en trámite',
                    90 => 'Cerrado',
                    91 => 'Habilitación vencida',
                    100 => 'Habilitado')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\ComercioBundle\Entity\Comercio'));
    }

    public function getName()
    {
        return 'yacare_tramitesbundle_comerciotype';
    }
}
