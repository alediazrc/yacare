<?php

namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActaTalonarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Tipo', 'entity', array(
                'label' => 'Tipo',
                'class' => 'YacareInspeccionBundle:ActaTipo',
                'required' => true))
            ->add('NumeroDesde', null, array('label' => 'Numeración desde'))
            ->add('NumeroHasta', null, array('label' => 'hasta'))
            ->add('EnPoderDe', 'entity', array(
                'label' => 'En poder de',
                'class' => 'YacareBaseBundle:Persona',
                'required' => false,
                'empty_value' => 'Sin especificar'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\InspeccionBundle\Entity\ActaTalonario'
        ));
    }

    public function getName()
    {
        return 'yacare_inspeccionbundle_actatalonariotype';
    }
}