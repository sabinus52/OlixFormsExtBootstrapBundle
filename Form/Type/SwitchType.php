<?php
/**
 * Widget de formulaire de type switch équivalent à une case à cocher
 * 
 * @name olix_switch
 * @service olix.formsext.type.switch
 * 
 * @param data-*
 * @link http://www.bootstrap-switch.org/options-3.html
 * @example 'attr' : { 'data-on-color' : "success", 'data-off-color' : "danger", 'data-on-text' : "OUI", 'data-on-text' : "NON" }
 *
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @link http://www.bootstrap-switch.org/
 * 
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 *
 */

namespace Olix\FormsExtBootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class SwitchType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }


    public function getParent()
    {
        return 'checkbox';
    }


    public function getName()
    {
        return 'olix_switch';
    }

}