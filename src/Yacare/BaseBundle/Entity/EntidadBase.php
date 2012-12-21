<?php

namespace Yacare\BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Yacare\BaseBundle\Entity\EntidadBase
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EntidadBase
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
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


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
