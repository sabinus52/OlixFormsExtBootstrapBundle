Composant Bootstrap-switch
==========================

Turn checkboxes and and radio buttons in toggle switches

Demo : http://www.bootstrap-switch.org/

Source : https://github.com/nostalgiaz/bootstrap-switch


### Default usage

Name of type : `olix_switch`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('my_switch1', 'olix_switch');
    
    // With attributes
    $builder->add('my_switch1', 'olix_switch', array(
        'attr' => array(
            'data-on-color' => "success",
            'data-off-color' => "danger",
            'data-on-text' => "Yes",
            'data-off-text' => "No",
        )
    ));
}
```

### Options

### Attributes

See http://www.bootstrap-switch.org/options-3.html for the list