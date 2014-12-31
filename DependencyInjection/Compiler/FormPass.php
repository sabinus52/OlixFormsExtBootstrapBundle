<?php
/**
 * Chargement dans la configuration des ressources Twig pour les formulaires
 * 
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @package Olix
 * @subpackage FormsExtBundle
 */

namespace Olix\FormsExtBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $resTwig = $container->getParameter('twig.form.resources');
        $isImported = in_array('OlixFormsExtBundle:Form:widgets_layout.html.twig', $resTwig)
                   && in_array('OlixFormsExtBundle:Form:javascript_layout.html.twig', $resTwig)
                   && in_array('OlixFormsExtBundle:Form:stylesheet_layout.html.twig', $resTwig);
        
        if (!$isImported) {
            $resTwig[] = 'OlixFormsExtBundle:Form:widgets_layout.html.twig';
            $resTwig[] = 'OlixFormsExtBundle:Form:javascript_layout.html.twig';
            $resTwig[] = 'OlixFormsExtBundle:Form:stylesheet_layout.html.twig';
            $container->setParameter('twig.form.resources', $resTwig);
        }
    }

}