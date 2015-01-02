<?php
/**
 * Bundle OlixFormsExtBootstrapBundle
 * 
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 */

namespace Olix\FormsExtBootstrapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Olix\FormsExtBootstrapBundle\DependencyInjection\Compiler\FormPass;


class OlixFormsExtBootstrapBundle extends Bundle
{

    /**
     * Compilation pour le chargement des paramètres de ressources de Twig
     * 
     * @see \Symfony\Component\HttpKernel\Bundle\Bundle::build()
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FormPass());
    }

}
