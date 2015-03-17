<?php
/**
 * Widget de formulaire de type text ou choice avec ajout d'un checkbox pour activer ou pas le widget
 * 
 * @name olix_checkbox_*
 * @service olix.formsext.type.checkbox_*
 * 
 * @param boolean enabled : Activer le widget par défaut
 *
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 *
 */

namespace Olix\FormsExtBootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;



class CheckboxAddonType extends AbstractType
{

    private $widget;


    /**
     * Constructeur
     *
     * @param string $widget : Nom du widget parent (text, choice, ...)
     */
    public function __construct($widget)
    {
        $this->widget = $widget;
    }


    /**
     * @see \Symfony\Component\Form\AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['config'] = $options['config'];
        
        // Remplace par 'olix_checkbox' dans le prefix block
        array_splice(
            $view->vars['block_prefixes'],
            array_search($this->getName(), $view->vars['block_prefixes']),
            0,
            'olix_checkbox'
        );
    }


    /**
     * @see \Symfony\Component\Form\AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'config' => array(),
        ));
        
        // Les options du widget par défaut
        $config = array(
            'enabled' => false,
        );
        $resolver->setNormalizers(array(
            'config' => function (Options $options, $value) use ($config) {
                $result = array_merge($config, $value);
                return $result;
            }
        ));
    }


    /**
     * @see \Symfony\Component\Form\AbstractType::getParent()
     */
    public function getParent()
    {
        return $this->widget;
    }


    /**
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'olix_checkbox_'.$this->widget;
    }

}