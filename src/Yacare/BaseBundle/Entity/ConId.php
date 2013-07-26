<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Yacare\BaseBundle\Helper\Damm;

/**
 * ConId
 *
 */
trait ConId
{
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
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    public function getDamm()
    {
        return Damm::CalcCheckDigit($this->id);
    }
 

    public function getYri64($incluye_version = true)
    {
        return base64_encode($this->getYri($incluye_version));
    }
    
    public function getYri($incluye_version = true)
    {
        // get_class() devuelve Yacare\TalBundle\Entity\TalEntidad
        // Tomo el segundo y cuarto valor (índices 1 y 3)
        $PartesNombreClase = explode('\\', get_class());
        $BundleName = str_replace('Bundle', '', $PartesNombreClase[1]);
        $ClassName = $PartesNombreClase[3];
        $Res = "http://yacare.riogrande.gob.ar/cp/?en=$BundleName+$ClassName&id=" . $this->getId();
        
        if($incluye_version && in_array('Yacare\BaseBundle\Entity\Versionable', class_uses($this)))
            $Res .= "&ver=" . $this->getVersion();
        
        return $Res;
    }
    
    
    public function getYriQrBase64() {
        $ContenidoQr = $this->getYri(true);

        ob_start();
        \PHPQRCode\QRcode::png($ContenidoQr);
        $imagen_contenido = ob_get_contents();
        ob_end_clean();
        
        // PHPQRCode cambia el content-type a image/png... lo volvemos a html
        header("Content-type: text/html");
        return base64_encode($imagen_contenido);
    }
}