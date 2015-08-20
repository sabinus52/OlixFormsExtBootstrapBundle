<?php
/**
 * Widget de formulaire de type autocomplete
 * 
 * @name olix_autocomplete
 * @service olix.formsext.type.autocomplete
 * 
 * @param config : liste des options de typeahead
 * @param dataset : liste des options de bloodhound
 * @link https://github.com/twitter/typeahead.js
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



class AutoCompleteType extends AbstractType
{

    /**
     * @see \Symfony\Component\Form\AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['config'] = $options['config'];
        $view->vars['dataset'] = $options['dataset'];
    }


    /**
     * @see \Symfony\Component\Form\AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'config' => array(),
            'dataset' => array(),
        ));
        
        // Les options du widget par défaut
        $config = array(
            'highlight'  => true,
            'classNames' => array(
                'menu' => 'typeahead-menu',
                'suggestion' => 'typeahead-suggestion',
            ),
        );
        $dataset = array(
            
        );
        
        $resolver->setNormalizers(array(
            'config' => function (Options $options, $value) use ($config) {
                $result = array_merge($config, $value);
                return $result;
            },
            'dataset' => function (Options $options, $value) use ($dataset) {
                $result = array_merge($dataset, $value);
                return $result;
            },
        ));
    }


    /**
     * @see \Symfony\Component\Form\AbstractType::getParent()
     */
    public function getParent()
    {
        return 'text';
    }


    /**
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'olix_autocomplete';
    }

}