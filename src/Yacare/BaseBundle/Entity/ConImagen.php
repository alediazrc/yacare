<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConImagen
 *
 */
trait ConImagen
{
    /**
     * @var $Imagen
     * @ORM\Column(name="Imagen", type="blob", nullable=true)
     */
    private $Imagen;

    public function getImagen() {
        return $this->Imagen;
    }

    public function setImagen($Imagen) {
        $this->Imagen = $Imagen;
    }
}