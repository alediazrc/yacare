<?php
namespace Yacare\TramitesBundle\Helper;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Maneja los eventos "lyfecycle" para actuar ante ciertos cambios en los estados de los requisitos de un trámite.
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
class EstadoRequisitoHelper
{
    public function LifecycleEvent(LifecycleEventArgs $args)
    {}
}
