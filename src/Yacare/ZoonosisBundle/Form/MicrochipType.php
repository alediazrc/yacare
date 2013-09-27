<?php

namespace Yacare\ZoonosisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MicrochipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('Microchip', null, array('label' => 'Microchip'))            
            ->add('FechaAplicacion', 'date', array(
                'years' => range(1900,2099),
                'widget' => 'single_text',
                'label' => 'Fecha de aplicacion'))
            ->add('Nombre', null, array('label' => 'Nombre'))
            ->add('TipoAnimal', 'choice', array(
                'choices'   => array(
                    '1' => 'Perro',
                    '2' => 'Gato',
                    '3' => 'Caballo',
                    ),
                'required'  => true,
                'label' => 'Tipo'))
            ->add('Raza', null, array('label' => 'Raza'))
            ->add('Sexo', 'choice', array(
                'choices'   => array(
                    '1' => 'Macho',
                    '2' => 'Hembra',
                    ),
                'required'  => true,
                'label' => 'Sexo'))
            ->add('Estado', 'choice', array(
                'choices'   => array(
                    '1' => 'Fertil',
                    '2' => 'Operado',
                    ),
                'required'  => true,
                'label' => 'Estado'))
            ->add('Pelaje', 'choice', array(
                'choices'   => array(
                    '1' => 'Corto',
                    '2' => 'Mediano',
                    '3' => 'Largo',
                    ),
                'required'  => true,
                'label' => 'Pelaje'))
            ->add('Color', null, array('label' => 'Color'))
            ->add('Peso', null, array('label' => 'Peso'))
            ->add('FechaNacimiento', 'date', array(
                'years' => range(1900,2099),
                'widget' => 'single_text',
                'label' => 'Fecha de nacimiento'))
            ->add('Origen', 'choice', array(
                'choices'   => array(
                    '1' => 'Compra',
                    '2' => 'Regalo',
                    '3' => 'Adopcion',
                    ),
                'required'  => true,
                'label' => 'Origen'))
            ->add('Dueno', null, array('label' => 'Dueño'))
            ->add('Domicilio', new \Yacare\BaseBundle\Form\DomicilioLocalType(), 
                    array(
                        'data_class' => 'Yacare\ZoonosisBundle\Entity\Microchip',
                        'label' => 'Domicilio')
                    )         
            ->add('Cerco', 'choice', array(
                'choices'   => array(
                    '1' => 'Ninguno',
                    '2' => 'Parcial',
                    '3' => 'Total',
                    ),
                'required'  => true,
                'label' => 'Cerco'))   
            ->add('ContactoAlternativo', null, array('label' => 'Contacto alternativo'))
            ->add('Veterinario', null, array('label' => 'Veterinario'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ZoonosisBundle\Entity\Microchip'
        ));
    }

    public function getName()
    {
        return 'yacare_zoonosisbundle_microchiptype';
    }
}