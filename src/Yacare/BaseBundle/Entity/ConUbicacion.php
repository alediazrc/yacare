<?php
namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agrega la ubicación (punto de latitud y longitud).
 */
trait ConUbicacion
{
    /**
     *
     * @var integer @ORM\Column(type="point")
     */
    private $UbicacionPunto = 0;


    public function getUbicacionPunto()
    {
        return $this->UbicacionPunto;
    }

    public function setUbicacionPunto($UbicacionPunto)
    {
        $this->UbicacionPunto = $UbicacionPunto;
        return $this;
    }
}