Composant Checkbox Addon
==================================

Checkbox within an input group's addon instead of text or choice.
On click, enable or disable the widget.


### Default usage

Name of type : 
* `olix_checkbox_text`
* `olix_checkbox_choice`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('tags', 'olix_collection');
    
    // With attributes
    $builder->add('tags', 'olix_checkbox_text', array(
        'label' => 'Tags',
        'config' => array('enabled' => true),
    ));
}
```

### Options

#### enabled
**type** : `boolean`, **default** : `false`

If true, enables the widget


