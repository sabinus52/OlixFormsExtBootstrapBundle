<?php
/**
 * Widget de formulaire de type select amélioré
 * 
 * @name olix_select2_*
 * @service olix.formsext.type.select2_*
 * 
 * @param config : liste des options de select2
 * @link http://select2.github.io/select2/
 *
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @link http://select2.github.io/
 * 
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 * 
 */

namespace Olix\FormsExtBootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;


class Select2Type extends AbstractType
{

    private $widget;


    /**
     * Constructeur
     * 
     * @param string $widget : Nom du widget parent (choice, entity, country, ...)
     */
    public function __construct($widget)
    {
        $this->widget = $widget;
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['config'] = $options['config'];
        
        // Remplace par 'olix_select2' dans le prefix block
        array_splice(
            $view->vars['block_prefixes'],
            array_search($this->getName(), $view->vars['block_prefixes']),
            0,
            'olix_select2'
        );
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //Propriétés du formulaire
        $resolver->setDefaults(array(
            'transformer'   => null,
            'expanded'      => false,
            'config'        => array(),
        ));
        $resolver->setAllowedValues(array(
            'expanded' => array(false),
        ));
        
        // Les options du widget par défaut
        $config = array();
        $resolver->setNormalizers(array(
            'config' => function (Options $options, $value) use ($config) {
                return array_merge($config, $value);
            }
        ));
    }


    public function getParent()
    {
        return $this->widget;
    }


    public function getName()
    {
        return 'olix_select2_'.$this->widget;
    }

}