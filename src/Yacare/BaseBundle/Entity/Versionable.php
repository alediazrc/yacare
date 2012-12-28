<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Versionable
 *
 */
trait Versionable
{
    /**
     * @var integer $Version
     *
     * @ORM\Column(name="Version", type="integer")
     * @ORM\Version
     */
    private $Version;

    /**
     * @var datetime $TimeStamp
     *
     * @ORM\Column(name="TimeStamp", type="datetime")
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
