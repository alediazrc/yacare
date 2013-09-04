<?php

namespace Yacare\TramitesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\TramitesBundle\Entity\TramiteRequisito
 *
 * @ORM\Entity
 * @ORM\Table(name="Tramites_TramiteRequisito")
 */
class TramiteRequisito
{
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConObs;
    use \Yacare\BaseBundle\Entity\Eliminable;

    /**
     * @ORM\ManyToOne(targetEntity="Tramite")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Tramite;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Propiedad;

    /**
     * @ORM\ManyToOne(targetEntity="Requisito")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $Requisito;
    
    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $Opcional;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CondicionQue;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $CondicionEs;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CondicionCuanto;

    public function getCondicion() {
        $res = '';
        if($this->CondicionQue) {
            $res .= $this->CondicionQue;
            switch($this->CondicionEs) {
                case '==';
                    $res .= ' es igual a ';
                    break;
                case '!=';
                    $res .= ' no es igual a ';
                    break;
                case '>';
                    $res .= ' es mayor que ';
                    break;
                case '<';
                    $res .= ' es menor que ';
                    break;
                case '>=';
                    $res .= ' es mayor o igual que ';
                    break;
                case '<=';
                    $res .= ' es menor o igual que ';
                    break;
                case 'null';
                    $res .= ' no existe';
                    break;
                case 'notnull';
                    $res .= ' existe';
                    break;
                case 'true';
                    $res .= ' es verdadero';
                    break;
                case 'false';
                    $res .= ' es falso';
                    break;
                default:
                    $res .= ' ' . $this->CondicionEs . ' ';
                    break;
            }
            if($this->CondicionCuanto)
                $res .= ' ' . $this->CondicionCuanto;
        }
        
        return $res;
    }

    public function __toString() {
        return (string)($this->Requisito);
    }
    
    
    
    public function getTramite() {
        return $this->Tramite;
    }

    public function setTramite($Tramite) {
        $this->Tramite = $Tramite;
    }

    public function getRequisito() {
        return $this->Requisito;
    }

    public function setRequisito($Requisito) {
        $this->Requisito = $Requisito;
    }

    public function getCondicionQue() {
        return $this->CondicionQue;
    }

    public function setCondicionQue($CondicionQue) {
        $this->CondicionQue = $CondicionQue;
    }

    public function getCondicionEs() {
        return $this->CondicionEs;
    }

    public function setCondicionEs($CondicionEs) {
        $this->CondicionEs = $CondicionEs;
    }

    public function getCondicionCuanto() {
        return $this->CondicionCuanto;
    }

    public function setCondicionCuanto($CondicionCuanto) {
        $this->CondicionCuanto = $CondicionCuanto;
    }

    public function getOpcional() {
        return $this->Opcional;
    }

    public function setOpcional($Opcional) {
        $this->Opcional = $Opcional;
    }
    
    public function getPropiedad() {
        return $this->Propiedad;
    }

    public function setPropiedad($Propiedad) {
        $this->Propiedad = $Propiedad;
    }
}
