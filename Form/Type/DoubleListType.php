<?php
/**
 * Widget de formulaire de selection multiple en double liste
 * 
 * @name olix_doublelist_*
 * @service olix.formsext.type.doublelist_*
 * 
 * @param config : liste des options de doublelist
 * @link http://loudev.com/
 *
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @link https://github.com/lou/multi-select
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
use Symfony\Component\Form\FormBuilderInterface;


class DoubleListType extends AbstractType
{

    private $widget;


    /**
     * Constructeur
     * 
     * @param string $widget : Nom du widget parent (choice, entity, ...)
     */
    public function __construct($widget)
    {
        $this->widget = $widget;
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['config'] = $options['config'];
        
        // Remplace par 'olix_doublelist' dans le prefix block
        array_splice(
            $view->vars['block_prefixes'],
            array_search($this->getName(), $view->vars['block_prefixes']),
            0,
            'olix_doublelist'
        );
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //Propriétés du formulaire
        $resolver->setDefaults(array(
            'multiple'      => true,
            'expanded'      => false,
            'config'        => array(),
        ));
        $resolver->setAllowedValues(array(
            'multiple' => array(true),
            'expanded' => array(false),
        ));
        
        // Les options du widget par défaut
        $config = array(
            'selectableHeader'  => '<div class="doublelist-header"><i>Selectionnable</i></div>',
            'selectionHeader'   => '<div class="doublelist-header">Selectionné</div>',
        );
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
        return 'olix_doublelist_'.$this->widget;
    }

}