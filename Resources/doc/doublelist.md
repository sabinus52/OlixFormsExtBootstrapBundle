Composant DoubleList
====================

A user-friendlier drop-in replacement for the standard select with multiple attribute activated.

Demo : http://loudev.com

Source : https://github.com/lou/multi-select


### Default usage

Name of type :
* `olix_doublelist_choice`
* `olix_doublelist_entity`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    // Entity
    $builder->add('my_select2', 'olix_doublelist_entity', array(
        'empty_value' => '',
        'class' => 'AcmeHelloBundle:User',
        'property' => 'username',
        'config' => array(
            'dblClick' => true,
        )
    ));
}
```

### Options

See http://loudev.com for the list

### Attributes

None
