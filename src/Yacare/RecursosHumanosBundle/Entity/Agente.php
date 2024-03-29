<?php
namespace Yacare\RecursosHumanosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Representa un agente municipal (empleado).
 *
 * Está relacionado a una persona.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 * @author Ezequiel Riquelme <rezequiel.tdf@gmail.com>
 * @author Alejandro Díaz <adiaz.rc@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="Tapir\BaseBundle\Entity\TapirBaseRepository")
 * @ORM\Table(name="Rrhh_Agente", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"})
 *     })
 */
class Agente
{
    use \Tapir\BaseBundle\Entity\ConId;
    use \Tapir\BaseBundle\Entity\ConObs;
    use \Tapir\BaseBundle\Entity\Versionable;
    use \Tapir\BaseBundle\Entity\Suprimible;
    use \Tapir\BaseBundle\Entity\Archivable;
    use \Tapir\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    public function __construct()
    {
        $this->Grupos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /*
     * CREATE VIEW rr_hh_agentes AS SELECT * FROM rr_hh.agentes;
     * CREATE OR REPLACE VIEW yacare.Rrhh_Agente AS SELECT agentes.legajo AS id, agentes.fechaingre AS FechaIngreso,
     * agentes.nombre AS NombreVisible, agentes.username, agentes.salt, agentes.password, agentes.is_active,
     * agentes.NombreSolo as Nombre, agentes.Apellido, agentes.email FROM rr_hh.agentes;
     * ALTER TABLE rr_hh.agentes ADD username VARCHAR(25) NOT NULL DEFAULT '', ADD salt VARCHAR(32) NOT NULL
     * DEFAULT '', ADD password VARCHAR(40) NOT NULL DEFAULT '', ADD NombreSolo VARCHAR(255) NOT NULL DEFAULT '',
     * ADD Apellido VARCHAR(255) NOT NULL DEFAULT '', CHANGE fechaingre fechaingre DATE NOT NULL,
     * CHANGE nombre nombre VARCHAR(255) NOT NULL DEFAULT '', CHANGE email email VARCHAR(255) NOT NULL DEFAULT '';
     * UPDATE yacare.Rrhh_Agente SET salt=MD5(RAND()) WHERE salt=''; UPDATE rr_hh.agentes SET
     * Apellido=TRIM(SUBSTRING_INDEX(nombre, ' ', 1)) WHERE NombreSolo=''; UPDATE rr_hh.agentes
     * SET NombreSolo=TRIM(TRIM(LEADING Apellido FROM nombre)) WHERE NombreSolo='';
     */
    
    /**
     * Los grupos a los cuales pertenece el agente.
     *
     * @var AgenteGrupo
     *
     * @ORM\ManyToMany(targetEntity="AgenteGrupo", inversedBy="Agentes")
     * @ORM\JoinTable(name="Rrhh_Agente_AgenteGrupo",
     *     joinColumns={@ORM\JoinColumn(name="agente_id", referencedColumnName="id", nullable=true)}
     * )
     */
    private $Grupos;
    
    /**
     * La persona asociada.
     *
     * @var \Yacare\BaseBundle\Entity\Persona
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $Persona;
    
    /**
     * La categoría actual.
     *
     * @var integer
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Categoria;
    
    /**
     * La situación del agente (Normal, baja, etc.).
     *
     * @var integer 
     * 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $Situacion;
    
    /**
     * La función que cumple, en formato de texto libre.
     *
     * @var string 
     * 
     * @ORM\Column(type="string")
     */
    private $Funcion;
    
    /**
     * La fecha de ingreso.
     * 
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de ingreso.")
     */
    private $FechaIngreso;
    
    /**
     * La fecha de baja, o NULL si todavía está activo.
     * 
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de baja.")
     */
    private $BajaFecha;
    
    /**
     * El motivo de la baja, o 0 si está activo.
     * 
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $BajaMotivo;
    
    /**
     * Nivel de estudios.
     * 
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    private $EstudiosNivel;
    
    /**
     * Título (refiere a los estudios).
     * 
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $EstudiosTitulo;
    
    /**
     * El departamento en el cual se desempeña.
     *
     * @var \Yacare\OrganizacionBundle\Entity\Departamento 
     * 
     * @ORM\ManyToOne(targetEntity="\Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Departamento;
    
    /**
     * Indica si es ex-combatiente.
     * 
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $ExCombatiente = 0;
    
    /**
     * Indica si es discapacitado.
     * 
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $Discapacitado = 0;
    
    /**
     * Indica cuál es la mano habil (0 = derecha, 1 = izquierda).
     * 
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    private $ManoHabil = 0;
    
    /**
     * La fecha de nacionalización.
     * 
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de nacionalización")
     */
    private $FechaNacionalizacion;
    
    /**
     * La última actualización de domicilio.
     * 
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de actualización de domicilio.")
     */
    private $UltimaActualizacionDomicilio;
    
    /**
     * El lugar de nacimiento.
     *
     * @var integer
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $LugarNacimiento;
    
    /**
     * La fecha de psicofísico.
     * 
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de exámen de psicofísico.")
     */
    private $FechaPsicofisico;
    
    /**
     * La fecha de certificado de buena conducta.
     *
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de certificado de buena conducta.")
     */
    private $FechaCertificadoBuenaConducta;
    
    /**
     * La fecha de certificado de antecedentes penales.
     *
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de certificado de antecedentes penales.")
     */
    private $FechaCertificadoAntecedentesPenales;
    
    /**
     * La fecha de certificado de domicilio.
     *
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione una fecha de certificado de domicilio.")
     */
    private $FechaCertificadoDomicilio;
    
    /**
     * El cargo del agente.
     * 
     * @var Cargo
     *
     * @ORM\ManyToOne(targetEntity="Cargo", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Cargo;
    
    /**
     * El sector en el cual se hace el parte diario de cada agente.
     *
     * @var \Yacare\OrganizacionBundle\Entity\Departamento
     *
     * @ORM\ManyToOne(targetEntity="\Yacare\OrganizacionBundle\Entity\Departamento")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $SectorParteDiario;
    
    /**
     * Indica si el agente aparece en el parte diario.
     * 
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ApareceEnParte;
    
    /**
     * Controla el horario del agente.
     * 
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ControlaHorario;
    
    /**
     * Indica si el agente marca en el reloj de control.
     * 
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $MarcaEnReloj;
    
    /**
     * Indica el banco al cual pertenece el agente.
     * 
     * @var \Yacare\BaseBundle\Entity\Banco
     *
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Banco", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private $Banco;
    
    /**
     * Indica el numero de cuenta asociado al agente.
     * 
     * @var integer
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    private $NumeroCuentaBanco;
    
    /**
     * Indica el CBU de la cuenta del agente.
     * 
     * @var string
     *
     * @ORM\Column(type="string", length=23 , nullable=true)
     */
    private $CBUCuentaAgente;
    
    /**
     * Indica la fecha en la que se da de baja el contrato, en caso que corresponda.
     * 
     * @var \Date
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(message="Por favor proporcione la fecha de baja del contrato.")
     */
    private $BajaFechaContrato;
    
    /**
     * El decreto asociado a la baja.
     * 
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    // @Assert\Regex(pattern="/^\s*(DM|RM|DC|RC|DJ|RJ|SI|SG|SF|SA|SO|SP|AD|OR|RG)\-(\d{1,5})\/(\d{4})\s*$/i",
    // message="Debe escribir el número de decreto en el formato DM-1234/2015."
    private $BajaDecreto;
    
    /**
     * Indica si la categoría es a cargo.
     * 
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $CategoriaACargo;
    
    /**
     * El horario de ingreso.
     * 
     * @var \Time 
     *
     * @ORM\Column(type="time", nullable=true)
     * @Assert\Time(message="Por favor proporcione un horario de ingreso.")
     */
    private $HorarioIngreso;
    
    /**
     * El horario de salida.
     * 
     * @var \Time
     *
     * @ORM\Column(type="time", nullable=true)
     * @Assert\Time(message="Por favor proporcione un horario de salida.")
     */
    private $HorarioSalida;
    
    /**
     * El horario de ingreso del segundo tramo.
     * 
     * @var \Time
     *
     * @ORM\Column(type="time", nullable=true)
     * @Assert\Time(message="Por favor proporcione un horario de segundo ingreso.")
     */
    private $Horario2Ingreso;
    
    /**
     * El horario de salida del segundo tramo.
     * 
     * @var \Time
     *
     * @ORM\Column(type="time", nullable=true)
     * @Assert\Time(message="Por favor proporcione un horario de segunda salida.")
     */
    private $Horario2Salida;

    /**
     * Calcula la antigüedad hasta la fecha indicada.
     * 
     * @param  \Date         $hastafecha fecha tope.
     * @return \DateInterval
     */
    public function AntiguedadLiquidacionHaberes($hastafecha = null)
    {
        return \Yacare\RecursosHumanosBundle\Helper\Antiguedades::CalcularAntiguedadHaberes($this->getFechaIngreso(), 
            $hastafecha);
    }

    public function __toString()
    {
        return $this->getPersona()->getNombreVisible();
    }

    /**
     * Normaliza nombres de situaciones laborales de un agente.
     * 
     * @param  integer $rango rango de codificación.
     * @return string         nombre nromalizado.
     */
    public static function SituacionesNombres($rango)
    {
        switch ($rango) {
            case 0:
                return 'Normal';
            case 1:
                return 'Licencia sin goce de haberes';
            case 2:
                return 'Baja';
            case 3:
                return 'Adscripción a otros organismos';
            case 4:
                return 'Largo tratamiento al 50%';
            case 5:
                return 'Ad-honorem';
            case 6:
                return 'Adscripción de otros organismos';
            case 7:
                return 'Pasantía rentada';
            case 8:
                return 'Pasantía no rentada';
            case 9:
                return 'Largo tratamiento al 100%';
            case 10:
                return 'Largo tratamiento sin goce de haberes';
            case 11:
                return 'Haberes 95% pasividad';
            case 12:
                return 'Gabinete';
            case 13:
                return 'Suspensión';
            default:
                return '';
        }
    }

    /**
     * Obtiene el nombre de la situación.
     *
     * @return string
     *
     * @see $Situacion $Situacion
     */
    public function getSituacionNombre()
    {
        return Agente::SituacionesNombres($this->getSituacion());
    }

    /**
     * Normaliza nombres de motivos de bajas.
     * 
     * @return string
     * 
     * @see $BajaMotivo $BajaMotivo
     */
    public static function BajaMotivoNombres($rango)
    {
        switch ($rango) {
            case 0:
                return 'n/a';
            case 1:
                return 'Renuncia';
            case 2:
                return 'Cesantía';
            case 3:
                return 'Rescinde contrato';
            case 4:
                return 'Finalización de contrato';
            case 5:
                return 'Jubilación';
            case 6:
                return 'Retiro';
            case 7:
                return 'Fallecimiento';
            default:
                return '';
        }
    }

    /**
     * Obtiene el nombre del motivo de baja.
     *
     * @return string
     *
     * @see $BajaMotivo $BajaMotivo
     */
    public function getBajaMotivoNombre()
    {
        return Agente::BajaMotivoNombres($this->getBajaMotivo());
    }

    /**
     * Normaliza nombres de niveles de estudio.
     * 
     * @return string
     * 
     * @see $EstudiosNivel $EstudiosNivel
     */
    public static function EstudiosNivelesNombres($rango)
    {
        switch ($rango) {
            case 0:
                return 'Sin escolaridad';
            case 1:
                return 'Menor de 4 años';
            case 2:
                return 'Primaria';
            case 3:
                return 'Secundaria';
            case 4:
                return 'Discapacitado';
            case 5:
                return 'Primaria / preescolar discapacitado';
            case 7:
                return 'Secundario discapacitado';
            case 8:
                return 'Preescolar';
            case 9:
                return 'Terciario';
            case 10:
                return 'Universitario';
            /**
             * TODO: la tabla "titulos" en la base de recursos tiene información sin sentido.
             * La info real está en el
             * Oracle de Payroll.
             */
            default:
                return '';
        }
    }

    /**
     * Obtiene el nombre del nivel de estudios.
     * 
     * @return string
     *
     * @see $EstudiosNivel $EstudiosNivel
     */
    public function getEstudiosNivelNombre()
    {
        return Agente::EstudiosNivelesNombres($this->getEstudiosNivel());
    }
    
    // *** Getters y setters
    
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
        return $this;
    }

    /**
     * @ignore
     */
    public function getPersona()
    {
        return $this->Persona;
    }

    /**
     * @ignore
     */
    public function setPersona($Persona)
    {
        $this->Persona = $Persona;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCategoria()
    {
        return $this->Categoria;
    }

    /**
     * @ignore
     */
    public function setCategoria($Categoria)
    {
        $this->Categoria = $Categoria;
        return $this;
    }

    /**
     * @ignore
     */
    public function getSituacion()
    {
        return $this->Situacion;
    }

    /**
     * @ignore
     */
    public function setSituacion($Situacion)
    {
        $this->Situacion = $Situacion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFuncion()
    {
        return $this->Funcion;
    }

    /**
     * @ignore
     */
    public function setFuncion($Funcion)
    {
        $this->Funcion = $Funcion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaIngreso()
    {
        return $this->FechaIngreso;
    }

    /**
     * @ignore
     */
    public function setFechaIngreso($FechaIngreso)
    {
        $this->FechaIngreso = $FechaIngreso;
        return $this;
    }

    /**
     * @ignore
     */
    public function getBajaFecha()
    {
        return $this->BajaFecha;
    }

    /**
     * @ignore
     */
    public function setBajaFecha($BajaFecha)
    {
        $this->BajaFecha = $BajaFecha;
        return $this;
    }

    /**
     * @ignore
     */
    public function getBajaMotivo()
    {
        return $this->BajaMotivo;
    }

    /**
     * @ignore
     */
    public function setBajaMotivo($BajaMotivo)
    {
        $this->BajaMotivo = $BajaMotivo;
        return $this;
    }

    /**
     * @ignore
     */
    public function getEstudiosNivel()
    {
        return $this->EstudiosNivel;
    }

    /**
     * @ignore
     */
    public function setEstudiosNivel($EstudiosNivel)
    {
        $this->EstudiosNivel = $EstudiosNivel;
        return $this;
    }

    /**
     * @ignore
     */
    public function getEstudiosTitulo()
    {
        return $this->EstudiosTitulo;
    }

    /**
     * @ignore
     */
    public function setEstudiosTitulo($EstudiosTitulo)
    {
        $this->EstudiosTitulo = $EstudiosTitulo;
        return $this;
    }

    /**
     * @ignore
     */
    public function getDepartamento()
    {
        return $this->Departamento;
    }

    /**
     * @ignore
     */
    public function setDepartamento($Departamento)
    {
        $this->Departamento = $Departamento;
        return $this;
    }

    /**
     * @ignore
     */
    public function getExCombatiente()
    {
        return $this->ExCombatiente;
    }

    /**
     * @ignore
     */
    public function setExCombatiente($ExCombatiente)
    {
        $this->ExCombatiente = $ExCombatiente;
        return $this;
    }

    /**
     * @ignore
     */
    public function getDiscapacitado()
    {
        return $this->Discapacitado;
    }

    /**
     * @ignore
     */
    public function setDiscapacitado($Discapacitado)
    {
        $this->Discapacitado = $Discapacitado;
        return $this;
    }

    /**
     * @ignore
     */
    public function getManoHabil()
    {
        return $this->ManoHabil;
    }

    /**
     * @ignore
     */
    public function setManoHabil($ManoHabil)
    {
        $this->ManoHabil = $ManoHabil;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaNacionalizacion()
    {
        return $this->FechaNacionalizacion;
    }

    /**
     * @ignore
     */
    public function setFechaNacionalizacion($FechaNacionalizacion)
    {
        $this->FechaNacionalizacion = $FechaNacionalizacion;
        return $this;
    }

    /**
     * @ignore
     */
    public function getUltimaActualizacionDomicilio()
    {
        return $this->UltimaActualizacionDomicilio;
    }

    /**
     * @ignore
     */
    public function setUltimaActualizacionDomicilio($UltimaActualizacionDomicilio)
    {
        $this->UltimaActualizacionDomicilio = $UltimaActualizacionDomicilio;
        return $this;
    }

    /**
     * @ignore
     */
    public function getLugarNacimiento()
    {
        return $this->LugarNacimiento;
    }

    /**
     * @ignore
     */
    public function setLugarNacimiento($LugarNacimiento)
    {
        $this->LugarNacimiento = $LugarNacimiento;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaPsicofisico()
    {
        return $this->FechaPsicofisico;
    }

    /**
     * @ignore
     */
    public function setFechaPsicofisico($FechaPsicofisico)
    {
        $this->FechaPsicofisico = $FechaPsicofisico;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaCertificadoBuenaConducta()
    {
        return $this->FechaCertificadoBuenaConducta;
    }

    /**
     * @ignore
     */
    public function setFechaCertificadoBuenaConducta($FechaCertificadoBuenaConducta)
    {
        $this->FechaCertificadoBuenaConducta = $FechaCertificadoBuenaConducta;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaCertificadoAntecedentesPenales()
    {
        return $this->FechaCertificadoAntecedentesPenales;
    }

    /**
     * @ignore
     */
    public function setFechaCertificadoAntecedentesPenales($FechaCertificadoAntecedentesPenales)
    {
        $this->FechaCertificadoAntecedentesPenales = $FechaCertificadoAntecedentesPenales;
        return $this;
    }

    /**
     * @ignore
     */
    public function getFechaCertificadoDomicilio()
    {
        return $this->FechaCertificadoDomicilio;
    }

    /**
     * @ignore
     */
    public function setFechaCertificadoDomicilio($FechaCertificadoDomicilio)
    {
        $this->FechaCertificadoDomicilio = $FechaCertificadoDomicilio;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCargo()
    {
        return $this->Cargo;
    }

    /**
     * @ignore
     */
    public function setCargo($Cargo)
    {
        $this->Cargo = $Cargo;
        return $this;
    }

    /**
     * @ignore
     */
    public function getSectorParteDiario()
    {
        return $this->SectorParteDiario;
    }

    /**
     * @ignore
     */
    public function setSectorParteDiario($SectorParteDiario)
    {
        $this->SectorParteDiario = $SectorParteDiario;
        return $this;
    }

    /**
     * @ignore
     */
    public function getApareceEnParte()
    {
        return $this->ApareceEnParte;
    }

    /**
     * @ignore
     */
    public function setApareceEnParte($ApareceEnParte)
    {
        $this->ApareceEnParte = $ApareceEnParte;
        return $this;
    }

    /**
     * @ignore
     */
    public function getControlaHorario()
    {
        return $this->ControlaHorario;
    }

    /**
     * @ignore
     */
    public function setControlaHorario($ControlaHorario)
    {
        $this->ControlaHorario = $ControlaHorario;
        return $this;
    }

    /**
     * @ignore
     */
    public function getMarcaEnReloj()
    {
        return $this->MarcaEnReloj;
    }

    /**
     * @ignore
     */
    public function setMarcaEnReloj($MarcaEnReloj)
    {
        $this->MarcaEnReloj = $MarcaEnReloj;
        return $this;
    }

    /**
     * @ignore
     */
    public function getBanco()
    {
        return $this->Banco;
    }

    /**
     * @ignore
     */
    public function setBanco($Banco)
    {
        $this->Banco = $Banco;
        return $this;
    }

    /**
     * @ignore
     */
    public function getNumeroCuentaBanco()
    {
        return $this->NumeroCuentaBanco;
    }

    /**
     * @ignore
     */
    public function setNumeroCuentaBanco($NumeroCuentaBanco)
    {
        $this->NumeroCuentaBanco = $NumeroCuentaBanco;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCBUCuentaAgente()
    {
        return $this->CBUCuentaAgente;
    }

    /**
     * @ignore
     */
    public function setCBUCuentaAgente($CBUCuentaAgente)
    {
        $this->CBUCuentaAgente = $CBUCuentaAgente;
        return $this;
    }

    /**
     * @ignore
     */
    public function getBajaFechaContrato()
    {
        return $this->BajaFechaContrato;
    }

    /**
     * @ignore
     */
    public function setBajaFechaContrato($BajaFechaContrato)
    {
        $this->BajaFechaContrato = $BajaFechaContrato;
        return $this;
    }

    /**
     * @ignore
     */
    public function getBajaDecreto()
    {
        return $this->BajaDecreto;
    }

    /**
     * @ignore
     */
    public function setBajaDecreto($BajaDecreto)
    {
        $this->BajaDecreto = $BajaDecreto;
        return $this;
    }

    /**
     * @ignore
     */
    public function getCategoriaACargo()
    {
        return $this->CategoriaACargo;
    }

    /**
     * @ignore
     */
    public function setCategoriaACargo($CategoriaACargo)
    {
        $this->CategoriaACargo = $CategoriaACargo;
        return $this;
    }

    /**
     * @ignore
     */
    public function getHorarioIngreso()
    {
        return $this->HorarioIngreso;
    }

    /**
     * @ignore
     */
    public function setHorarioIngreso($HorarioIngreso)
    {
        $this->HorarioIngreso = $HorarioIngreso;
        return $this;
    }

    /**
     * @ignore
     */
    public function getHorarioSalida()
    {
        return $this->HorarioSalida;
    }

    /**
     * @ignore
     */
    public function setHorarioSalida($HorarioSalida)
    {
        $this->HorarioSalida = $HorarioSalida;
        return $this;
    }

    /**
     * @ignore
     */
    public function getHorario2Ingreso()
    {
        return $this->Horario2Ingreso;
    }

    /**
     * @ignore
     */
    public function setHorario2Ingreso($Horario2Ingreso)
    {
        $this->Horario2Ingreso = $Horario2Ingreso;
        return $this;
    }

    /**
     * @ignore
     */
    public function getHorario2Salida()
    {
        return $this->Horario2Salida;
    }

    /**
     * @ignore
     */
    public function setHorario2Salida($Horario2Salida)
    {
        $this->Horario2Salida = $Horario2Salida;
        return $this;
    }
}
