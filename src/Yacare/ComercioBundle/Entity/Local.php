<?php
namespace Yacare\ComercioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\ComercioBundle\Entity\Local
 *
 * @ORM\Entity
 * @ORM\Table(name="Comercio_Local")
 */
class Local {
    use \Yacare\BaseBundle\Entity\ConId;
    use \Yacare\BaseBundle\Entity\ConNombre;
    //use \Yacare\BaseBundle\Entity\ConDomicilioLocal;
    use \Yacare\BaseBundle\Entity\Suprimible;
    use \Yacare\BaseBundle\Entity\Versionable;
    use \Yacare\CatastroBundle\Entity\ConPartida;
    use \Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\BaseBundle\Entity\Persona")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $Propietario;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $Tipo;
    
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $Superficie;
    
    /**
     * @ORM\ManyToOne(targetEntity="Yacare\ComercioBundle\Entity\DepositoClase")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    protected $DepositoClase;
    
    
    public function setPartida($Partida) {
        $this->Partida = $Partida;
        $this->setPropietario($Partida->getTitular());
    }
    
    private function ConstruirNombre() {
        if($this->getPartida()) {
            $this->setNombre($this->getTipo() . ' en ' .  $this->getPartida()->getDomicilio());
        } else {
            $this->setNombre($this->getTipo());
        }
    }
    
    public function getPropietario() {
        return $this->Propietario;
    }

    public function setPropietario($Propietario) {
        $this->Propietario = $Propietario;
        $this->ConstruirNombre();
    }
    
    public function getTipo() {
        return $this->Tipo;
    }

    public function setTipo($Tipo) {
        $this->Tipo = $Tipo;
        $this->ConstruirNombre();
    }
    
    public function getSuperficie() {
        return $this->Superficie;
    }

    public function setSuperficie($Superficie) {
        $this->Superficie = $Superficie;
    }
    
    public function getDepositoClase() {
        return $this->DepositoClase;
    }

    public function setDepositoClase($DepositoClase) {
        $this->DepositoClase = $DepositoClase;
    }
}
