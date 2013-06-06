<?php

namespace Yacare\OrganizacionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DependenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre', null, array('label' => 'Nombre', 'required' => true))
            ->add('Domicilio', null, array('label' => 'Domicilio'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\OrganizacionBundle\Entity\Dependencia'
        ));
    }

    public function getName()
    {
        return 'yacare_organizacionbundle_dependenciatype';
    }
}