<?php
namespace Yacare\RequerimientosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario para requerimientos anónimos.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class RequerimientoAnonimoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('Notas', null, array(
                'label' => 'Asunto', 
                'attr' => array('placeholder' => ''), 
                'required' => true))
            ->add('Categoria', 'entity', array(
                'label' => 'Categoría', 
                'attr' => array(
                    'help' => 'Si no sabe cual seleccionar, puede dejarla en blanco para que el administrador asigne una.'), 
                'class' => 'Yacare\RequerimientosBundle\Entity\Categoria', 
                'query_builder' => function (\Yacare\RequerimientosBundle\Entity\CategoriaRepository $er) {
                    return $er->ObtenerQueryBuilderPublicas();
                }, 
                'required' => false))
            ->add('UsuarioNombre', null, array(
                'label' => 'Nombre', 
                'attr' => array('placeholder' => 'Su nombre'), 
                'required' => false))
            ->add('UsuarioEmail', null, array(
                'label' => 'E-mail', 
                'attr' => array('placeholder' => 'Su dirección de correo electrónico'), 
                'required' => false))
            ->add('UsuarioDireccion', null, array(
                'label' => 'Dirección', 
                'attr' => array('placeholder' => 'Su domicilio'), 
                'required' => false))
            ->add('UsuarioTelefono', null, array(
                'label' => 'Teléfono', 
                'attr' => array('placeholder' => 'Su número de teléfono'), 
                'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Yacare\RequerimientosBundle\Entity\Requerimiento'));
    }

    public function getName()
    {
        return 'yacare_requerimientosbundle_requerimientoanonimotype';
    }
}
