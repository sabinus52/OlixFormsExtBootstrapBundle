<?php
/**
 * Bundle OlixFormsExtBundle
 * 
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @package Olix
 * @subpackage FormsExtBundle
 */

namespace Olix\FormsExtBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Olix\FormsExtBundle\DependencyInjection\Compiler\FormPass;


class OlixFormsExtBundle extends Bundle
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
