<?php
namespace Yacare\MunirgBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tapir\BaseBundle\Helper\StringHelper;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @Route("ldap/")
 */
class LdapController extends Controller
{
    /**
     * @Route("enrolarinicio/")
     * @Route("usuario_alta/", name="usuario_alta")
     * @Template()
     */
    public function enrolarinicioAction(Request $request)
    {}

    /**
     * @Route("enrolarverificar/")
     * @Template()
     */
    public function enrolarverificarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $Dominio = 'municipiorg.gob.ar';
        $Usuario = $request->get('_username');
        $Contrasena = $request->get('_password');
        $Documento = str_replace(array(
            '.', 
            ' ', 
            '-', 
            ','), '', $request->get('_documento'));
        
        if (! $Documento || ! $Usuario || ! $Contrasena) {
            $this->get('session')
                ->getFlashBag()
                ->add('danger', 'Por favor escriba los datos solicitados.');
            
            return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
        }
        
        $Persona = $em->getRepository('YacareBaseBundle:Persona')->findBy(array(
            'DocumentoNumero' => $Documento));
        if (count($Persona) < 1) {
            $this->get('session')
                ->getFlashBag()
                ->add('danger', 
                'No se encuentra una persona relacionada al DNI Nº ' . $Documento . ' en la base de datos.');
            
            return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
        } else 
            if (count($Persona) > 1) {
                $this->get('session')
                    ->getFlashBag()
                    ->add('danger', 'Hay más de una persona asociada al DNI Nº ' . $Documento . ' en la base de datos.');
                
                return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
            }
        
        $Persona = $Persona[0];
        
        $IdAgente = $Persona->getAgenteId();
        if (! $IdAgente) {
            $this->get('session')
                ->getFlashBag()
                ->add('danger', 'No se encuentra un agente municipal relacionado al DNI Nº ' . $Documento . '.');
            
            return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
        }
        
        if ($IdAgente) {
            $Agente = $em->getRepository('YacareRecursosHumanosBundle:Agente')->find($IdAgente);
            if (! $Agente) {
                $this->get('session')
                    ->getFlashBag()
                    ->add('warning', 'No se encuentra un agente municipal relacionado al DNI Nº ' . $Documento);
                
                return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
            }
        }
        
        $ServidorAd = \ldap_connect('192.168.100.44');
        ldap_set_option($ServidorAd, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ServidorAd, LDAP_OPT_REFERRALS, 0);
        $UsrBind = @\ldap_bind($ServidorAd, $Usuario . '@' . $Dominio, $Contrasena);
        if ($UsrBind) {
            return array(
                'agente' => $Agente, 
                'usuario' => $Usuario, 
                'contrasena' => $Contrasena, 
                'documento' => $Documento);
        } else {
            $extended_error = '';
            if (ldap_get_option($ServidorAd, LDAP_OPT_ERROR_STRING, $extended_error)) {
                echo "Error Binding to LDAP: $extended_error";
            } else {
                echo "Error Binding to LDAP: No additional information is available.";
            }
            $this->get('session')
                ->getFlashBag()
                ->add('danger', 
                'No se puede conectar con la cuenta proporcionada. Verifique el nombre de usuario y la contraseña.');
            
            return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
        }
    }

    /**
     * @Route("enrolarguardar/")
     * @Template()
     */
    public function enrolarguardarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $Dominio = 'municipiorg.gob.ar';
        $Usuario = $request->get('_username');
        $Contrasena = $request->get('_password');
        $Documento = str_replace(array(
            '.', 
            ' ', 
            '-', 
            ','), '', $request->get('_documento'));
        
        $Persona = $em->getRepository('YacareBaseBundle:Persona')->findBy(array(
            'DocumentoNumero' => $Documento));
        if (count($Persona) != 1) {
            $this->get('session')
                ->getFlashBag()
                ->add('danger', 
                'No se encuentra una persona relacionada al DNI Nº ' . $Documento . ' en la base de datos.');
            
            return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
        }
        
        $Persona = $Persona[0];
        
        $IdAgente = $Persona->getAgenteId();
        if (! $IdAgente) {
            $this->get('session')
                ->getFlashBag()
                ->add('danger', 'No se encuentra un agente municipal relacionado al DNI Nº ' . $Documento . '.');
            
            return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
        }
        
        if ($IdAgente) {
            $Agente = $em->getRepository('YacareRecursosHumanosBundle:Agente')->find($IdAgente);
            if (! $Agente) {
                $this->get('session')
                    ->getFlashBag()
                    ->add('warning', 'No existe ningún agente con DNI Nº ' . $Documento);
                
                return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
            }
        }
        
        $ServidorAd = \ldap_connect('192.168.100.44');
        ldap_set_option($ServidorAd, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ServidorAd, LDAP_OPT_REFERRALS, 0);
        $UsrBind = @\ldap_bind($ServidorAd, $Usuario . '@' . $Dominio, $Contrasena);
        ldap_unbind($ServidorAd);
        if ($UsrBind) {
            $Persona = $Agente->getPersona();
            
            $ldap = new \Yacare\MunirgBundle\Helper\LdapHelper($this->container);
            $GruposAnteriores = $ldap->ObtenerGruposAnteriores($Agente);
            $GruposActuales = $Agente->getGrupos();
            
            // Agrego los grupos al agente
            $GruposAgentes = $em->getRepository('YacareRecursosHumanosBundle:AgenteGrupo')->findAll();
            foreach ($GruposAnteriores as $GrupoAnterior) {
                // echo "Verificando " . $GrupoAnterior . '<br />';
                $existe = false;
                // Busco si ya está asociado a este grupo
                foreach ($GruposActuales as $GrupoActual) {
                    if (strcasecmp($GrupoAnterior, $GrupoActual->getNombreLdap()) == 0) {
                        $existe = true;
                        // echo "Ya está en el grupo " . $GrupoActual . '<br />';
                        break;
                    }
                }
                
                // El agente no está en el grupo. Lo agrego
                if (! $existe) {
                    // echo "No existe en " . $GrupoAnterior;
                    foreach ($GruposAgentes as $Grupo) {
                        if (strcasecmp($GrupoAnterior, $Grupo->getNombreLdap()) == 0) {
                            // echo "Agregando al grupo " . $Grupo . '<br />';
                            $Agente->getGrupos()->add($Grupo);
                        }
                    }
                }
            }
            
            // Actualizo sal, usuario, contraseña encodeada y contraseña hash
            $Persona->setSalt(md5(uniqid(null, true)));
            $Persona->setUsername($Usuario);
            $Persona->setPasswordEnc($Contrasena);
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($Persona);
            $ContrasenaEnc = $encoder->encodePassword($Contrasena, $Persona->getSalt());
            $Persona->setPassword($ContrasenaEnc);
            
            $em->persist($Persona);
            $em->flush();
            
            $ldap->AgregarOActualizarAgente($Agente);
            $ldap->CambiarContrasena($Agente);
            $ldap = null;
            
            return array(
                'agente' => $Agente, 
                'usuario' => $Usuario, 
                'contrasena' => $Contrasena, 
                'documento' => $Documento);
        } else {
            $this->get('session')
                ->getFlashBag()
                ->add('danger', 
                'No se puede conectar con la cuenta proporcionada. Verifique el nombre de usuario y la contraseña.');
            
            return $this->redirect($this->generateUrl('yacare_munirg_ldap_enrolarinicio'));
        }
    }
}
