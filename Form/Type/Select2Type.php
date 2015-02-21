<?php
/**
 * Widget de formulaire de type select amélioré
 * 
 * @name olix_select2_*
 * @service olix.formsext.type.select2_*
 * 
 * @param config : liste des options de select2
 * @link http://select2.github.io/select2/
 * Uniquement pour le mode 'hidden' : remote data
 * @param query : résultats de la requête de recherche du mot
 * @param ajax : résultats distants en Ajax de la requête de recherche du mot
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
use Symfony\Component\Form\FormBuilderInterface;


class Select2Type extends AbstractType
{

    /**
     * Liste des paramètres "Select2" comme type "function"
     * @var array
     */
    static protected $paramsFunction = array(
        'maximumSelectionSize',
        'placeholderOption',
        'id',
        'matcher',
        'sortResults',
        'formatSelection',
        'formatResult',
        'formatResultCssClass',
        'formatNoMatches',
        'formatAjaxError',
        'formatInputTooShort',
        'formatInputTooLong',
        'formatSelectionTooBig',
        'formatLoadMore',
        'createSearchChoice',
        'createSearchChoicePosition',
        'initSelection',
        'tokenizer',
        'tags',
        'containerCss',
        'containerCssClass',
        'dropdownCss',
        'dropdownCssClass',
        'adaptContainerCssClass',
        'adaptDropdownCssClass',
        'escapeMarkup',
        'nextSearchTerm',
    );


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


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*if ('hidden' === $this->widget && !empty($options['config']['multiple'])) {
            $builder->addViewTransformer(new ArrayToStringTransformer());
        } elseif ('hidden' === $this->widget && empty($options['config']['multiple']) && null !== $options['transformer']) {
            $builder->addModelTransformer($options['transformer']);
        }*/
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // Séparation des paramètres de type de 'function' et les autres
        $view->vars['config'] = $view->vars['cfgfct'] = array();
        foreach ($options['config'] as $config => $value) {
            if (in_array($config, self::$paramsFunction)) {
                $view->vars['cfgfct'][$config] = $value;
            } else {
                $view->vars['config'][$config] = $value;
            }
        }
        
        if (isset($options['query'])) {
            $view->vars['query'] = $options['query'];
        }
        if (isset($options['ajax'])) {
            $view->vars['ajax'] = $options['ajax'];
        }
        
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
        if ($this->widget === 'hidden') {
            $resolver->setDefaults(array(
                'query' => null,
                'ajax'  => array(),
            ));
        }
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