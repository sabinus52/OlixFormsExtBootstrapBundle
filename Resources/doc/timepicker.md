Composant Bootstrap-datetimepicker
==================================

Time picker widget based on twitter bootstrap

Demo : http://www.malot.fr/bootstrap-datetimepicker/

Source : https://github.com/smalot/bootstrap-datetimepicker


### Default usage

Name of type : `olix_timepicker`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('my_timepicker1', 'olix_timepicker');
    
    // With attributes
    $builder->add('my_timepicker2', 'olix_timepicker', array(
        'config' => array(
            'locale' => "fr",
            'format' => "HH:mm",
        )
    ));
}
```

### Options

#### locale
**type** : `string`, **default** : `%locale%`

Language, the two-letter code of the language to use for month and day names

#### format
**type** : `string`, **default** : `HH:mm`

The date format. This format is surcharged by the options `format` of options form symfony into format ICU

#### startDate
**type** : `string`, **default** : Beginning of hour (format *HH:mm*)

The earliest date that may be selected; all earlier dates will be disabled

#### endDate
**type** : `string`, **default** : End of hour (format *HH:mm*)

The latest date that may be selected; all later dates will be disabled.

#### minuteStep
**type** : `integer` or `boolean`, **default** : `5`

The increment used to build the hour view

#### pickerPosition
**type** : `string`, **default** : `bottom-left`

This option is currently only available in the component implementation. With it you can place the picker just under the input field.

### Attributes

None