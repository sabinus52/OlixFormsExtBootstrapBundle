Composant Collection
==================================

Collection widget based on symfony collection forms

Source : http://symfony.com/doc/current/reference/forms/types/collection.html


### Default usage

Name of type : `olix_collection`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('tags', 'olix_collection');
    
    // With attributes
    $builder->add('tags', 'olix_collection', array(
        'label' => 'Tags',
        'type'   => new TagsFormType(),
        'allow_add' => true,
        'allow_delete' => true,
        'by_reference' => false,
        'sortable' => true,
        'sortable_field' => 'order',
    ));
}
```

### Options

#### sortable
**type** : `boolean`, **default** : `false`

If true, enables UI sortable feature, allowing user to reorder items with drag&drop.
The position will be stored in a hidden input for field defined in `sortable_field`

#### sortable_field
**type** : `string`, **default** : `order`

If `sortable` is enabled, this option is used to specify the name of field, which should hold sortable position

