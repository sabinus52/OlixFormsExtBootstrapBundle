<?php
/**
 * Widget de formulaire de type datepicker
 * 
 * @name olix_datepicker
 * @service olix.formsext.type.datepicker
 * 
 * @param locale : language (default : %locale%)
 * @param format : Format d'affichage du widget (default : yyyy-mm-dd)
 * @param startDate : Date de debut activée
 * @param endDate : Date de fin activé
 * @param todayBtn : Affichage du bouton "today"
 * @param pickerPosition : Position du picker
 *
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @link http://www.malot.fr/bootstrap-datetimepicker/
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

use Olix\FormsExtBootstrapBundle\Helpers\DateConverter;


class DatePickerType extends AbstractType
{

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['config'] = $options['config'];
        
        // Conversion du format depuis ICU défini dans l'options 'format'
        $view->vars['config']['format'] = DateConverter::convertDateIcuToWdgtBootstapDatetimePicker($options['format'], 'date');
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //Propriétés du formulaire non modifiables
        $resolver->setDefaults(array(
            'widget'    => 'single_text',
            'format'    => 'yyyy-MM-dd',
            'read_only' => true,
            'config'    => array(),
        ));
        $resolver->setAllowedValues(array(
            'widget' => array('single_text'),
            'read_only' => array(true),
            'format' => array('yyyy-MM-dd', 'yyyy.MM.dd', 'yyyy/MM/dd', 'dd-MM-yyyy', 'dd.MM.yyyy', 'dd/MM/yyyy', 'MM-dd-yyyy', 'MM.dd.yyyy', 'MM/dd/yyyy'),
        ));
        
        // Les options du widget par défaut
        $config = array(
            'locale'            => \Locale::getDefault(),
            'format'            => 'yyyy-mm-dd',
            'startDate'         => '',
            'endDate'           => '',
            'todayBtn'          => false,
            'pickerPosition'    => 'bottom-left',
        );
        $resolver->setNormalizers(array(
            'config' => function (Options $options, $value) use ($config) {
                $result = array_merge($config, $value);
                return $result;
            }
        ));
    }


    public function getParent()
    {
        return 'date';
    }


    public function getName()
    {
        return 'olix_datepicker';
    }

}