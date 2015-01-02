<?php
/**
 * Extension pour l'affichage du code javascript et stylesheet de chaque widget du formulaire
 *
 * @author Olivier <sabinus52@gmail.com>
 *
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 */

namespace Olix\FormsExtBootstrapBundle\Twig\Extension;

use Symfony\Bridge\Twig\Form\TwigRendererInterface;
use Symfony\Component\Form\FormView;


class FormExtension extends \Twig_Extension
{

    /**
     * @var Symfony\Bridge\Twig\Form\TwigRendererInterface
     */
    public $renderer;


    /**
     * Constructeur
     * 
     * @param TwigRendererInterface $renderer
     */
    public function __construct(TwigRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }


    /**
     * Déclaration des fonctions
     * 
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
        return array(
            'form_javascript' => new \Twig_Function_Method($this, 'renderJavascript', array('is_safe' => array('html'))),
            'form_stylesheet' => new \Twig_Function_Method($this, 'renderStylesheet', array('is_safe' => array('html'))),
        );
    }


    /**
     * Fonction de rendu javascript du formulaire
     * 
     * @param FormView $view
     */
    public function renderJavascript(FormView $view)
    {
        return $this->renderer->searchAndRenderBlock($view, 'javascript');
    }


    /**
     * Fonction de rendu des feuilles de style du formulaire
     * 
     * @param FormView $view
     */
    public function renderStylesheet(FormView $view)
    {
        return $this->renderer->searchAndRenderBlock($view, 'stylesheet');
    }


    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'olix.formsext.twig.extension.form';
    }

}