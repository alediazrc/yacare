<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new JMS\AopBundle\JMSAopBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Liuggio\ExcelBundle\LiuggioExcelBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new Ivory\GoogleMapBundle\IvoryGoogleMapBundle(),

            new Indepnet\GlpiBundle\IndepnetGlpiBundle(),

            new Tapir\BaseBundle\TapirBaseBundle(),
            new Tapir\ChartsBundle\TapirChartsBundle(),
        	new Tapir\AnnotationBundle\TapirAnnotationBundle(),
            new Tapir\TemplateBundle\TapirTemplateBundle(),
            new Tapir\FormBundle\TapirFormBundle(),

            new Yacare\BaseBundle\YacareBaseBundle(),
            new Yacare\TemplateBundle\YacareTemplateBundle(),
            new Yacare\RecursosHumanosBundle\YacareRecursosHumanosBundle(),
            new Yacare\InspeccionBundle\YacareInspeccionBundle(),
            new Yacare\CatastroBundle\YacareCatastroBundle(),
            new Yacare\OrganizacionBundle\YacareOrganizacionBundle(),
            new Yacare\ComprasBundle\YacareComprasBundle(),
            new Yacare\ComercioBundle\YacareComercioBundle(),
            new Yacare\TramitesBundle\YacareTramitesBundle(),
            new Yacare\MunirgBundle\YacareMunirgBundle(),
            new Yacare\ObrasParticularesBundle\YacareObrasParticularesBundle(),
            new Yacare\RequerimientosBundle\YacareRequerimientosBundle(),
            new Yacare\AdministracionBundle\YacareAdministracionBundle(),
            //new Yacare\SuitBundle\YacareSuitBundle(),
            new Yacare\SitioWebBundle\YacareSitioWebBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
