<?php

namespace Yacare\CatastroBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\CatastroBundle\Entity\Partida
 *
 * @ORM\Table(name="Catastro_Partida")
 * @ORM\Entity
 * 
 * UPDATE Catastro_Partida 
	SET Nombre=CONCAT('Sección ', Seccion, ', macizo ', MacizoAlfa, MacizoNum, ', parcela ', ParcelaAlfa, ParcelaNum);
 * UPDATE Catastro_Partida 
	SET CalleNumero=NULL WHERE CalleNumero=0;
 * 
 */
class Partida
{
    use \Yacare\BaseBundle\Entity\Timestampable;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\BaseBundle\Entity\Importable;

    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;
    
    /**
     * @var string $Nombre
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

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
     * @ORM\ManyToOne(targetEntity="Calle")
     * @ORM\JoinColumn(name="Calle", referencedColumnName="id")
     */
    protected $Calle;

    /**
     * @var string $CalleNumero
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CalleNumero;
    
    /**
     * @var string $CalleNumeroExtension
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CalleNumeroExtension;

    public function getId()
    {
        return $this->id;
    }
    
    public function getNombre() {
        $this->Nombre = "Sección " . $this->Seccion . ", macizo " . $this->MacizoAlfa . $this->MacizoNum . ", parcela " . $this->ParcelaAlfa . $this->ParcelaNum;
        return $this->Nombre;
    }

    public function setNombre($Nombre) {
        $this->Nombre = "Sección " . $this->Seccion . ", macizo " . $this->MacizoAlfa . $this->MacizoNum . ", parcela " . $this->ParcelaAlfa . $this->ParcelaNum;
    }

    public function getSeccion() {
        return $this->Seccion;
    }

    public function setSeccion($Seccion) {
        $this->Seccion = $Seccion;
    }

    public function getMacizoAlfa() {
        return $this->MacizoAlfa;
    }

    public function setMacizoAlfa($MacizoAlfa) {
        $this->MacizoAlfa = $MacizoAlfa;
    }

    public function getMacizoNum() {
        return $this->MacizoNum;
    }

    public function setMacizoNum($MacizoNum) {
        $this->MacizoNum = $MacizoNum;
    }

    public function getParcelaAlfa() {
        return $this->ParcelaAlfa;
    }

    public function setParcelaAlfa($ParcelaAlfa) {
        $this->ParcelaAlfa = $ParcelaAlfa;
    }

    public function getParcelaNum() {
        return $this->ParcelaNum;
    }

    public function setParcelaNum($ParcelaNum) {
        $this->ParcelaNum = $ParcelaNum;
    }

    public function getCalle() {
        return $this->Calle;
    }

    public function setCalle($Calle) {
        $this->Calle = $Calle;
    }

    public function getCalleNumero() {
        return $this->CalleNumero;
    }

    public function setCalleNumero($CalleNumero) {
        $this->CalleNumero = $CalleNumero;
    }

    public function getCalleNumeroExtension() {
        return $this->CalleNumeroExtension;
    }

    public function setCalleNumeroExtension($CalleNumeroExtension) {
        $this->CalleNumeroExtension = $CalleNumeroExtension;
    }

}