<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntidadVersionable
 *
 */
class EntidadVersionable
{
    /**
     * @var integer $Version
     *
     * @ORM\Column(name="Version", type="integer")
     * @version
     */
    private $Version;

    /**
     * @var integer $TimeStamp
     *
     * @ORM\Column(name="TimeStamp", type="datetime")
     * @version
     */
    private $TimeStamp;
    
    public function getVersion() {
        return $this->Version;
    }

    public function setVersion($Version) {
        $this->Version = $Version;
    }

    public function getTimeStamp() {
        return $this->TimeStamp;
    }

    public function setTimeStamp($TimeStamp) {
        $this->TimeStamp = $TimeStamp;
    }
}

?>
