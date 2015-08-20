Composant TypeAhead.js
======================

typeahead.js is a fast and fully-featured autocomplete library

Demo : http://twitter.github.io/typeahead.js/examples/

Source : https://github.com/twitter/typeahead.js


### Default usage

Name of type : `olix_autocomplete`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('my_autocomplete1', 'olix_autocomplete', array(
        'dataset' => array('local' => array('toto', 'titi', 'tutu'))
    ));
    
    // With attributes
    $builder->add('my_autocomplete2', 'olix_autocomplete', array(
        'config' => array(
            'display' => "'nom'",
            'limit' => 10,
            'minLength' => 2,
        ),
        'dataset' => array(
            'remote' => array(
                'url' => $this->generateUrl('my_route_xxxxx', array('term' => 'TERM')),
                'wildcard' => 'TERM'),
            ),
        ),
    );
}
```

### Options

#### highlight
**type** : `boolean`, **default** : `true`

If true, when suggestions are rendered, pattern matches for the current query in text nodes

#### hint
**type** : `boolean`, **default** : `true`

If false, the typeahead will not show a hint.

#### minLength
**type** : `integer`, **default** : `2`

The minimum character length needed before suggestions start getting rendered

#### classNames
**type** : `array`, **default** : 

For overriding the default class names used. [See for more details](https://github.com/twitter/typeahead.js/blob/master/doc/jquery_typeahead.md#class-names)

#### limit
**type** : `integer`, **default** : `8`

The max number of suggestions to be displayed

#### display
**type** : `string`, **default** : none

For a given suggestion, determines the string representation of it


### Dataset

Bloodhound is the typeahead.js suggestion engine

[See attributes](https://github.com/twitter/typeahead.js/blob/master/doc/bloodhound.md)