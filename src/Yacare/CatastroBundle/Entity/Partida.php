<?php

namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Partida
 *
 * @ORM\Table(name="Catastro_Partida",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="ImportSrcId", columns={"ImportSrc", "ImportId"}),
 *          @ORM\UniqueConstraint(name="SeccionMacizoParcelaUf", columns={"Seccion", "Macizo", "Parcela", "UnidadFuncional"})
 *      },
 *      indexes={
 *          @ORM\Index(name="Catastro_Partida_ImportSrcId", columns={"ImportSrc", "ImportId"}),
 *          @ORM\Index(name="Catastro_Partida_SeccionMacizoParcelaUf", columns={"Seccion", "Macizo", "Parcela", "UnidadFuncional"})
 *      }
 * )
 * @ORM\Entity
 * 
 * UPDATE Catastro_Partida 
	SET Nombre=CONCAT('Sección ', Seccion, ', macizo ', MacizoAlfa, MacizoNum, ', parcela ', ParcelaAlfa, ParcelaNum);
 * UPDATE Catastro_Partida 
	SET DomicilioNumero=NULL WHERE DomicilioNumero=0;
 * 
 */
class Partida
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    use \Yacare\BaseBundle\Entity\ConDomicilioLocal;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Importable;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

    /**
     * @var string $Seccion
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Seccion;
    
    /**
     * @var string $MacizoAlfa
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $MacizoAlfa;
    
    /**
     * @var string $MacizoNum
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $MacizoNum;
    
    /**
     * @var string $Macizo
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Macizo;
    
    /**
     * @var string $ParcelaAlfa
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ParcelaAlfa;
    
    /**
     * @var string $ParcelaNum
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ParcelaNum;
    
    /**
     * @var string $Parcela
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Parcela;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $UnidadFuncional;
    
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Zonificacion;
    
    /**
     * @var
     * @ORM\Column(type="integer")
     */
    private $Numero;
    
    
    /**
     * @var
     * @ORM\Column(type="integer")
     */
    private $Legajo;
    
    
    
    public function CalcularNombre()
    {
        $this->Nombre = "Sección " . $this->getSeccion() . ", macizo " . $this->getMacizoNum() . $this->getMacizoAlfa() . ", parcela " . $this->getParcelaNum() . $this->getParcelaAlfa();
        if($this->UnidadFuncional > 0) {
            $this->Nombre .= ', UF ' . $this->UnidadFuncional;
        }
    }
    
    
    
    public function getNombre() {
        $this->CalcularNombre();
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->CalcularNombre();
    }

    public function getSeccion() {
        return $this->Seccion;
    }

    public function setSeccion($Seccion) {
        $this->Seccion = $Seccion;
        $this->CalcularNombre();
    }

    public function getMacizoAlfa() {
        return $this->MacizoAlfa;
    }

    public function setMacizoAlfa($MacizoAlfa) {
        $this->MacizoAlfa = $MacizoAlfa;
        $this->CalcularNombre();
    }

    public function getMacizoNum() {
        return $this->MacizoNum;
    }

    public function setMacizoNum($MacizoNum) {
        $this->MacizoNum = $MacizoNum;
        $this->CalcularNombre();
    }

    public function getParcelaAlfa() {
        return $this->ParcelaAlfa;
    }

    public function setParcelaAlfa($ParcelaAlfa) {
        $this->ParcelaAlfa = $ParcelaAlfa;
        $this->CalcularNombre();
    }

    public function getParcelaNum() {
        return $this->ParcelaNum;
    }

    public function setParcelaNum($ParcelaNum) {
        $this->ParcelaNum = $ParcelaNum;
        $this->CalcularNombre();
    }

    public function getMacizo() {
        return $this->Macizo;
    }

    public function setMacizo($Macizo) {
        $this->Macizo = $Macizo;
        $this->CalcularNombre();
    }

    public function getParcela() {
        return $this->Parcela;
    }

    public function setParcela($Parcela) {
        $this->Parcela = $Parcela;
        $this->CalcularNombre();
    }
    
    public function getZonificacion() {
        return $this->Zonificacion;
    }

    public function setZonificacion($Zonificacion) {
        $this->Zonificacion = $Zonificacion;
        $this->CalcularNombre();
    }
    
    public function getUnidadFuncional() {
        return $this->UnidadFuncional;
    }

    public function getLegajo() {
        return $this->Legajo;
    }

    public function setUnidadFuncional($UnidadFuncional) {
        $this->UnidadFuncional = $UnidadFuncional;
        $this->CalcularNombre();
    }

    public function setLegajo($Legajo) {
        $this->Legajo = $Legajo;
        $this->CalcularNombre();
    }
    
    public function getNumero() {
        return $this->Numero;
    }

    public function setNumero($Numero) {
        $this->Numero = $Numero;
        $this->CalcularNombre();
    }
}
