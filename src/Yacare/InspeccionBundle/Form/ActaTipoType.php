<?php
namespace Yacare\InspeccionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActaTipoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nombre', null, array('label' => 'Nombre'))
            ->add('Departamento', 'entity', 
            array(
                'label' => 'Departamento',
                'placeholder' => 'Sin especificar',
                'class' => 'YacareOrganizacionBundle:Departamento',
                'required' => false,
                'query_builder' => function (\Tapir\BaseBundle\Entity\TapirBaseRepository $er)
                {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.MaterializedPath', 'ASC');
                },
                'property' => 'NombreConSangriaDeEspaciosDuros'))
            ->add('Clase', null, array('label' => 'Clase'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\InspeccionBundle\Entity\ActaTipo'));
    }

    public function getName()
    {
        return 'yacare_inspeccionbundle_actatipotype';
    }
}
