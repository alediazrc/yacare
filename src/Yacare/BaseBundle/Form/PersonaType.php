<?php

namespace Yacare\BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Apellido')
            ->add('Nombre')
            ->add('RazonSocial')
            ->add('TipoDocumento')
            ->add('NumeroDocumento')
            ->add('Calle')
            ->add('NumeroCalle')
            ->add('Piso')
            ->add('Puerta')
            ->add('NumeroTelefono')
            ->add('Email')
            ->add('PersonaJuridica')
            ->add('CodigoPostal')
            ->add('FechaNacimiento')
            ->add('Genero')
            ->add('Nacionalidad')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\BaseBundle\Entity\Persona'
        ));
    }

    public function getName()
    {
        return 'yacare_basebundle_personatype';
    }
}
