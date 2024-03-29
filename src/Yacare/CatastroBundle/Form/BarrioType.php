<?php
namespace Yacare\CatastroBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para barrios.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class BarrioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('NombreAlternativo', null, array('label' => 'Nombre alternativo'))
            ->add('Ordenanza', null, array('label' => 'Ordenanza'))
            ->add('Notas', null, array('label' => 'Límites'))
            ->add('Obs', null, array('label' => 'Obs.'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\CatastroBundle\Entity\Barrio'));
    }

    public function getName()
    {
        return 'yacare_catastrobundle_barriotype';
    }
}
