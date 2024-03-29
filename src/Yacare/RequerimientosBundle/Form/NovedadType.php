<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de nvoedades internas.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class NovedadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('Notas', null, array(
                'label' => 'Descripción',
                'required' => true))
            ->add('Privada', new \Tapir\BaseBundle\Form\Type\PrivadoType(), array(
                'label' => 'Visibilidad',
                'attr' => array(
                    'help' => 'Los comentarios públicos se muestran a todos los usuarios, incluso los anónimos. Los
                        comentarios privados los ven sólo los usuarios que intervienen en el requerimiento.'),
                'required' => true))
            ->add('Usuario', 'entity_hidden', array(
                'class' => 'Yacare\BaseBundle\Entity\Persona'))
            ->add('Requerimiento', 'entity_hidden', array(
                'class' => 'Yacare\RequerimientosBundle\Entity\Requerimiento'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\RequerimientosBundle\Entity\Novedad'));
    }

    public function getName()
    {
        return 'yacare_requerimientosbundle_novedadtype';
    }
}
