<?php

namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelevamientoResultadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Grupo', 'choice', array(
                'choices'   => array(
                    'Obras particulares' => 'Obras particulares',
                    'Ecología' => 'Ecología',
                    'Bromatología' => 'Bromatología',
                    'Comercio' => 'Comercio',
                    'Tránsito' => 'Tránsito'
                    ),
                'required'  => false,
                'label' => 'Grupo'))
            ->add('Nombre', null, array('label' => 'Nombre'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\InspeccionBundle\Entity\RelevamientoResultado'
        ));
    }

    public function getName()
    {
        return 'yacare_inspeccionbundle_relevamientoresultadotype';
    }
}