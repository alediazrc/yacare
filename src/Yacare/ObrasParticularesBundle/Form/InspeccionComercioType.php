<?php
namespace Yacare\ObrasParticularesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario de inspección de comercio.
 * 
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class InspeccionComercioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Partida', 'entity_id', array(
                'label' => 'Partida', 
                'class' => 'Yacare\CatastroBundle\Entity\Partida', 
                'required' => true))
            ->add('TitularNombre', null, array(
                'label' => 'Propietario'))
            ->add('Actividades', new \Yacare\ComercioBundle\Form\Type\ActividadesType(), array(
                'label' => 'Actividades ClaMAE 2014'))
            ->add('ActividadNombre', null, array(
                'label' => 'Actividades'))
            ->add('NumeroSolicitud', null, array(
                'label' => 'Nº de solicitud'))
            ->add('ExpedienteNumero', null, array(
                'label' => 'Nº de expediente'))
            ->add('Obs', null, array(
                'label' => 'Obs.'))
            ->add('EstadoTramite', 'choice', array(
                'label' => 'Instancia del trámite', 
                'required' => true, 
                'choices' => array(
                    'Catastro y Planeamiento' => 'Catastro y Planeamiento Urbano', 
                    'Obras Particulares-Inspeccion Tecnica' => 'Obras Particulares (Inspección)', 
                    'Pendiente-ObrasParticulares' => 'Obras Particulares (Pendiente)')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yacare\ObrasParticularesBundle\Entity\InspeccionComercio'));
    }

    public function getName()
    {
        return 'yacare_obrasparticularesbundle_inspeccioncomerciotype';
    }
}
