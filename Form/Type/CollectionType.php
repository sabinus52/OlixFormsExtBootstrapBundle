<?php
/**
 * Widget de formulaire de type collection
 * 
 * @name olix_collection
 * @service olix.formsext.type.collection
 * 
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 *
 */

namespace Olix\FormsExtBootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;


class CollectionType extends AbstractType
{

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['sortable'] = $options['sortable'];
        $view->vars['sortable_field'] = $options['sortable_field'];
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'sortable' => false,
            'sortable_field' => 'order',
        ));
        
        $resolver->setAllowedTypes('sortable', 'bool');
        $resolver->setAllowedTypes('sortable_field', 'string');
    }


    public function getParent()
    {
        return 'collection';
    }


    public function getName()
    {
        return 'olix_collection';
    }

}