<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Tapir\BaseBundle\Entity\PersonaInterface;

/**
 * Una persona (física o jurídica).
 *
 * Representa una persona física o jurídica. Es el repositorio principal de
 * personas, que todas las entidades que representan personas (por ejemplo
 * Usuario, Agente, Proveedor, etc.) deben encapsular.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Yacare\BaseBundle\Entity\PersonaRepository")
 * @ORM\Table(name="Base_Persona", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})},
 *     indexes={
 *         @ORM\Index(name="Base_Persona_ImportSrcId", columns={"ImportSrc", "ImportId"}),
 *         @ORM\Index(name="Base_Persona_Documento", columns={"DocumentoTipo", "DocumentoNumero"}),
 *         @ORM\Index(name="Base_Persona_Cuilt", columns={"Cuilt"}),
 *         @ORM\Index(name="Base_Persona_NombreVisible", columns={"NombreVisible"})
 * })
 */
class Persona implements PersonaInterface, UserInterface, \Serializable
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConImagen;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    use \Yacare\BaseBundle\Entity\ConDomicilio;
    use \Yacare\BaseBundle\Entity\ConVerificacion;

    /**
     * Los grupos a los cuales pertenece la persona.
     *
     * @var PersonaGrupo
     *
     * @ORM\ManyToMany(targetEntity="PersonaGrupo", inversedBy="Personas")
     * @ORM\JoinTable(name="Base_Persona_PersonaGrupo",
     *     joinColumns={@ORM\JoinColumn(name="Persona_id", referencedColumnName="id", nullable=true)})
     */
    private $Grupos;

    /**
     * Los roles asignados al usuario.
     *
     * @var \Tapir\BaseBundle\Entity\PersonaRol
     *
     * @ORM\ManyToMany(targetEntity="Tapir\BaseBundle\Entity\PersonaRol", inversedBy="Personas")
     * @ORM\JoinTable(name="Base_Persona_PersonaRol",
     *     joinColumns={@ORM\JoinColumn(name="Persona_id", referencedColumnName="id", nullable=true)})
     */
    private $UsuarioRoles;

    public function __construct()
    {
        $this->Grupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->UsuarioRoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * Los apellidos.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $Apellido;

    /**
     * Los nombres de pila.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

    /**
     * El nombre que se prefiere para representar a la persona.
     *
     * Suele ser la combinación de apellido y nombre para las personas físicas
     * y la razón social para las personas jurídicas.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $NombreVisible;

    /**
     * El nombre de usuario.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=25, unique=true, nullable=true)
     */
    private $Username;

    /**
     * La sal con la cual se hace el extracto de la contraseña.
     *
     * @var string
     *
     * @see $Password $Password
     *
     * @ORM\Column(type="string", length=255)
     */
    private $Salt = '892ddb02bed8aafcddbff7f78f8841d6'; // Sal predeterminada

    /**
     * El extracto de la contraseña.
     *
     * @var string
     *
     * @see $Salt $Salt
     *
     * @ORM\Column(type="string", length=255)
     */
    private $Password = 'ae6786579adda2bfffc032a0693a2f79ec34591d'; // Contraseña predeterminada 123456

    /**
     * La contraseña codificada.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $PasswordEnc = 'MTIzNDU2'; // Contraseña predeterminada 123456, con base64

    /**
     * La razón social (sólo para personas jurídicas).
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RazonSocial = null;

    /**
     * El tipo de documento.
     *
     * @var integer
     *
     * @see $DocumentoNumero $DocumentoNumero
     *
     * @ORM\Column(type="integer")
     */
    private $DocumentoTipo;

    /**
     * El número de documento.
     *
     * @var string
     *
     * @see $DocumentoTipo $DocumentoTipo
     *
     * @ORM\Column(type="string")
     * @Assert\Length(min = "3", max="10")
     */
    private $DocumentoNumero;

    /**
     * El CUIL o CUIT.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Cuilt;

    /**
     * El o los números de teléfono en formato de texto libre.
     *
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $TelefonoNumero;

    /**
     * El nivel de verificación del campo TelefonoNumero.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $TelefonoVerificacionNivel = 0;

    /**
     * La dirección de correo electrónico.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message = "El mail '{{ value }}' no es una dirección válida.")
     */
    private $Email;

    /**
     * El nivel de verificación del campo Email.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $EmailVerificacionNivel = 0;

    /**
     * La situación tributaria, según AFIP.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $SituacionTributaria;

    /**
     * La fecha de nacimiento.
     *
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de nacimiento.")
     */
    private $FechaNacimiento;

    /**
     * Género (sólo personas físicas).
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Genero = 0;

    /**
     * Estado civil (sólo personas físicas).
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $EstadoCivil = 0;

    /**
     * El país de nacionalidad.
     *
     * @var Pais
     *
     * @see \Yacare\BaseBundle\Entity\Pais Pais
     *
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $Pais;

    /* Columnas de importación del municipio de Río Grande */

    /**
     * El id original en la tabla del SiGeMI.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Tg06100Id;

    /**
     * El agente asociado, en caso de ser un agente municipal.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $AgenteId;

    /**
     * El número de ingresos brutos.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Nib;

    /**
     * El tipo de sociedad de una persona, sea física o jurídica.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $TipoSociedad;

    /**
     * Devuelve el nombre de la situación tributaria de la persona.
     */
    public function getSituacionTributariaNombre()
    {
        return self::SituacionTributariaNombres($this->getSituacionTributaria());
    }

    /**
     * Devuelve una cadena de descripción para un valor de SituacionTributaria.
     */
    public static function SituacionTributariaNombres($SituacionTributaria)
    {
        switch ($SituacionTributaria) {
            case '1':
                return 'IVA Responsable Inscripto';
            case '2':
                return 'IVA Responsable no Inscripto';
            case '3':
                return 'IVA no Responsable';
            case '4':
                return 'IVA Sujeto Exento';
            case '5':
                return 'Consumidor Final';
            case '6':
                return 'Responsable Monotributo';
            case '7':
                return 'Sujeto no Categorizado';
            case '8':
                return 'Proveedor del Exterior';
            case '9':
                return 'Cliente del Exterior';
            case '10':
                return 'IVA Liberado – Ley Nº 19.640';
            case '11':
                return 'IVA Responsable Inscripto – Agente de Percepción';
            case '12':
                return 'Pequeño Contribuyente Eventual';
            case '13':
                return 'Monotributista Social';
            case '14':
                return 'Pequeño Contribuyente Eventual Social';
            default:
                return '???';
        }
    }

    /**
     * Devuelve el nombre del tipo de sociedad de la persona.
     *
     * @return string
     */
    public function getTipoSociedadNombre()
    {
        return self::TipoSociedadNombres($this->getTipoSociedad());
    }

    /**
     * Devuelve una cadena de descripción para un valor de TipoSociedad.
     *
     * @param  string $TipoSociedad
     * @return string
     */
    public static function TipoSociedadNombres($TipoSociedad)
    {
        switch ($TipoSociedad) {
            case null:
                return 'Persona física / Empresa Unipersonal';
            case '1':
                return 'Sociedad Anónima';
            case '2':
                return 'Sociedad Colectiva';
            case '3':
                return 'Sociedad de Hecho';
            case '4':
                return 'Sociedad en Comandita por Acciones';
            case '5':
                return 'Sociedad de Capital e Industria';
            case '6':
                return 'Sociedad Accidental o en Participación';
            case '7':
                return 'Sociedad en Comandita Simple';
            case '8':
                return 'Sociedad de Responsabilidad Limitada';
            case '9':
                return 'Cooperativa';
            case '10':
                return 'Asociación Sin Fines de Lucro';
            default:
                return '???';
        }
    }

    /**
     * Devuelve true si si trata de una persona física.
     */
    public function EsPersonaFisica() {
        return $this->getTipoSociedad() == null;
    }

    /**
     * Devuelve true si si trata de un consumidor final.
     */
    public function EsConsumidorFinal() {
        return ($this->getSituacionTributaria() == 5) || ($this->getSituacionTributaria() == 9);
    }

    /**
     * Devuelve el campo Cuilt, formateado con guiones (12-12345678-9).
     *
     * @return string
     */
    public function CuiltFormateado()
    {
        return \Tapir\BaseBundle\Helper\Cuilt::FormatearCuilt($this->Cuilt);
    }

    /**
     * Devuelve el campo Cuilt si tiene. De lo contrario devuelve el documento.
     *
     * @return string
     */
    public function CuiltODocumento()
    {
        if ($this->Cuilt) {
            return $this->CuiltFormateado();
        } else {
            return $this->DocumentoNumero;
        }
    }

    /**
     * Devuelve un nombre amigable como "Juan Pérez" en lugar de "Pérez, Juan".
     *
     * @return string
     */
    public function NombreAmigable()
    {
        if ($this->RazonSocial) {
            return $this->RazonSocial;
        } else {
            if ($this->Apellido && $this->Nombre) {
                return $this->Nombre . ' ' . $this->Apellido;
            } else {
                if ($this->Nombre) {
                    return $this->Nombre;
                } else {
                    return $this->Apellido;
                }
            }
        }
        return $this->getNombreVisible();
    }

    /**
     * Devuelve un nombre amigable como "Juan" en lugar de "Pérez, Juan".
     *
     * @return string
     */
    public function NombreAmigableCorto()
    {
        if ($this->RazonSocial) {
            return $this->RazonSocial;
        } else {
            if ($this->Nombre) {
                return $this->Nombre;
            }
        }
        return $this->NombreAmigable();
    }

    /**
     * Construye un nombre visible.
     *
     * @see $NombreVisible $NombreVisible
     *
     * @return string
     */
    public function getNombreVisible()
    {
        if ($this->RazonSocial) {
            $this->NombreVisible = $this->RazonSocial;
        } else {
            if ($this->Apellido && $this->Nombre) {
                $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
            } else {
                if ($this->Nombre) {
                    $this->NombreVisible = $this->Nombre;
                } else {
                    $this->NombreVisible = $this->Apellido;
                }
            }
        }
        return trim($this->NombreVisible, ',');
    }

    /**
     * Establece el nombre visible.
     *
     * @param string $NombreVisible el nombre de preferencia para mostrar.
     */
    public function setNombreVisible($NombreVisible)
    {
        if ($this->RazonSocial) {
            $this->NombreVisible = $this->RazonSocial;
        } else
            if ($this->Apellido && $this->Nombre) {
                $this->NombreVisible = $this->Apellido . ', ' . $this->Nombre;
            } else
                if ($this->Nombre) {
                    $this->NombreVisible = $this->Nombre;
                } else {
                    $this->NombreVisible = $this->Apellido;
                }
        $this->NombreVisible = trim($this->NombreVisible, ',');
    }

    /**
     * Normaliza el género.
     *
     * @param  integer $genero rango de clasificación.
     * @return string
     */
    public static function GenerosNombres($genero)
    {
        switch ($genero) {
            case 0:
                return 'Sin especificar';
            case 1:
                return 'Masculino';
            case 2:
                return 'Femenino';
            case 3:
                return 'Otro';
            default:
                return 'n/a';
        }
    }

    /**
     * Normaliza el estado civil.
     *
     * @param  integer $genero rango de clasificación.
     * @return string
     */
    public static function EstadosCivilesNombres($genero)
    {
        switch ($genero) {
            case 0:
                return 'Sin especificar';
            case 1:
                return 'Soltero/a';
            case 2:
                return 'Casado/a';
            case 3:
                return 'Divorciado/a';
            case 4:
                return 'Viudo/a';
            case 5:
                return 'En concubinato';
            case 6:
                return 'Separado/a';
            default:
                return 'n/a';
        }
    }

    /**
     * Devuelve el nombre del género normalizado.
     *
     * @return string
     */
    public function getGeneroNombre()
    {
        return Persona::GenerosNombres($this->getGenero());
    }

    /**
     * Devuelve el nombre del estado civil normalizado.
     *
     * @return string
     */
    public function getEstadoCivilNombre()
    {
        return Persona::EstadosCivilesNombres($this->getEstadoCivil());
    }

    /**
     * Devuelve TRUE si el usuario puede acceder a la aplicación.
     *
     * @return boolean
     */
    public function PuedeAcceder()
    {
        return $this->getUsername() && $this->getPasswordEnc();
    }

    /**
     * Devuelve los roles pertenecientes a un usuario determinado.
     *
     * @return string
     */
    public function getRoles()
    {
        $res = $this->UsuarioRoles->toArray();
        if ($this->PuedeAcceder() && in_array('ROLE_USUARIO', $res) == false) {
            /*
             * Todos los usuarios tienen el rol USUARIO (simpre que tengan una contraseña)
             */
            $res[] = 'ROLE_USUARIO';
        }
        return $res;
    }

    /**
     * Setea la contraseña codificada en base 64.
     *
     * @param string $PasswordEnc
     */
    public function setPasswordEnc($PasswordEnc)
    {
        $this->PasswordEnc = base64_encode($PasswordEnc);

        // Actualizo la sal y la contraseña con hash
        /*
         * $this->setSalt(md5(uniqid(null, true)));
         * $factory = $this->get('security.encoder_factory');
         * $encoder = $factory->getEncoder($this);
         * $encoded_password = $encoder->encodePassword($this->getPasswordEnc(), $this->getSalt());
         * $this->setPassword($encoded_password);
         */
    }

    /**
     * Setea el número de documento, previamente eliminando caracteres irrelevantes.
     * * Ejemplo: puntos (.), comas (,), guiones (-), etc.
     *
     * @param string $DocumentoNumero
     */
    public function setDocumentoNumero($DocumentoNumero)
    {
        $this->DocumentoNumero = str_replace(array('.', ',', ' '), '', $DocumentoNumero);
    }

    /**
     * Setea el cuilt, realizando previamente un formateo.
     *
     * @param string $Cuilt
     */
    public function setCuilt($Cuilt)
    {
        $this->Cuilt = \Tapir\BaseBundle\Helper\Cuilt::FormatearCuilt($Cuilt);
    }

    public function __toString()
    {
        return $this->getNombreVisible();
    }

    public function eraseCredentials()
    {}

    /**
     * @see \Serializable::serialize() \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array($this->id));
    }

    /**
     * @see \Serializable::unserialize() \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list ($this->id, ) = unserialize($serialized);
    }

    /**
     * @ignore
     */
    public function setUsername($Username)
    {
        $this->Username = strtolower($Username);
    }

    /**
     * @ignore
     */
    public function getPasswordEnc()
    {
        return base64_decode($this->PasswordEnc);
    }

    /**
     * @ignore
     */
    public function isEqualTo(UserInterface $user)
    {
        return $this->id === $user->getId();
    }

    /**
     * @ignore
     */
    public function getApellido()
    {
        return $this->Apellido;
    }

    /**
     * @ignore
     */
    public function setApellido($Apellido)
    {
        $this->Apellido = $Apellido;
        $this->getNombreVisible();
    }

    /**
     * @ignore
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * @ignore
     */
    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
        $this->getNombreVisible();
    }

    /**
     * @ignore
     */
    public function getRazonSocial()
    {
        return $this->RazonSocial;
        $this->getNombreVisible();
    }

    /**
     * @ignore
     */
    public function setRazonSocial($RazonSocial)
    {
        $this->RazonSocial = $RazonSocial;
    }

    /**
     * @ignore
     */
    public function getDocumentoTipo()
    {
        return $this->DocumentoTipo;
    }

    /**
     * @ignore
     */
    public function setDocumentoTipo($DocumentoTipo)
    {
        $this->DocumentoTipo = $DocumentoTipo;
    }

    /**
     * @ignore
     */
    public function getDocumentoNumero()
    {
        return $this->DocumentoNumero;
    }

    /**
     * @ignore
     */
    public function getCuilt()
    {
        return $this->Cuilt;
    }

    /**
     * @ignore
     */
    public function getTelefonoNumero()
    {
        return $this->TelefonoNumero;
    }

    /**
     * @ignore
     */
    public function setTelefonoNumero($TelefonoNumero)
    {
        $this->TelefonoNumero = $TelefonoNumero;
    }

    /**
     * @ignore
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @ignore
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
    }

    /**
     * @ignore
     */
    public function getSituacionTributaria()
    {
        return $this->SituacionTributaria;
    }

    /**
     * @ignore
     */
    public function setSituacionTributaria($SituacionTributaria)
    {
        $this->SituacionTributaria = $SituacionTributaria;
    }

    /**
     * @ignore
     */
    public function getFechaNacimiento()
    {
        return $this->FechaNacimiento;
    }

    /**
     * @ignore
     */
    public function setFechaNacimiento(\DateTime $FechaNacimiento = null)
    {
        $this->FechaNacimiento = $FechaNacimiento;
    }

    /**
     * @ignore
     */
    public function getGenero()
    {
        return $this->Genero;
    }

    /**
     * @ignore
     */
    public function setGenero($Genero)
    {
        $this->Genero = $Genero;
    }

    /**
     * @ignore
     */
    public function getPais()
    {
        return $this->Pais;
    }

    /**
     * @ignore
     */
    public function setPais($Pais)
    {
        $this->Pais = $Pais;
    }

    /**
     * @ignore
     */
    public function getGrupos()
    {
        return $this->Grupos;
    }

    /**
     * @ignore
     */
    public function setGrupos($Grupos)
    {
        $this->Grupos = $Grupos;
    }

    /**
     * @ignore
     */
    public function getUsername()
    {
        return $this->Username;
    }

    /**
     * @ignore
     */
    public function getSalt()
    {
        return $this->Salt;
    }

    /**
     * @ignore
     */
    public function setSalt($Salt)
    {
        $this->Salt = $Salt;
    }

    /**
     * @ignore
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @ignore
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;
    }

    /**
     * @ignore
     */
    public function getUsuarioRoles()
    {
        return $this->UsuarioRoles;
    }

    /**
     * @ignore
     */
    public function setUsuarioRoles($UsuarioRoles)
    {
        $this->UsuarioRoles = $UsuarioRoles;
    }

    /**
     * @ignore
     */
    public function getTg06100Id()
    {
        return $this->Tg06100Id;
    }

    /**
     * @ignore
     */
    public function getAgenteId()
    {
        return $this->AgenteId;
    }

    /**
     * @ignore
     */
    public function setTg06100Id($Tg06100Id)
    {
        $this->Tg06100Id = $Tg06100Id;
    }

    /**
     * @ignore
     */
    public function setAgenteId($AgenteId)
    {
        $this->AgenteId = $AgenteId;
    }

    /**
     * @ignore
     */
    public function getVerificacionNivel()
    {
        return $this->VerificacionNivel;
    }

    /**
     * @ignore
     */
    public function setVerificacionNivel($VerificacionNivel)
    {
        $this->VerificacionNivel = $VerificacionNivel;
    }

    /**
     * @ignore
     */
    public function getEstadoCivil()
    {
        return $this->EstadoCivil;
    }

    /**
     * @ignore
     */
    public function setEstadoCivil($EstadoCivil)
    {
        $this->EstadoCivil = $EstadoCivil;
        return $this;
    }

    /**
     * @ignore
     */
    public function getTelefonoVerificacionNivel()
    {
        return $this->TelefonoVerificacionNivel;
    }

    /**
     * @ignore
     */
    public function setTelefonoVerificacionNivel($TelefonoVerificacionNivel)
    {
        $this->TelefonoVerificacionNivel = $TelefonoVerificacionNivel;
        return $this;
    }

    /**
     * @ignore
     */
    public function getEmailVerificacionNivel()
    {
        return $this->EmailVerificacionNivel;
    }

    /**
     * @ignore
     */
    public function setEmailVerificacionNivel($EmailVerificacionNivel)
    {
        $this->EmailVerificacionNivel = $EmailVerificacionNivel;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNib()
    {
        return $this->Nib;
    }

    /**
     * @ignore
     */
    public function setNib($Nib)
    {
        $this->Nib = $Nib;
        return $this;
    }

    /**
     * @ignore
     */
    public function getTipoSociedad()
    {
        return $this->TipoSociedad;
    }

    /**
     * @ignore
     */
    public function setTipoSociedad($TipoSociedad)
    {
        $this->TipoSociedad = $TipoSociedad;
        return $this;
    }
}
