Composant Bootstrap-datetimepicker
==================================

Both Date and Time picker widget based on twitter bootstrap

Demo : http://www.malot.fr/bootstrap-datetimepicker/

Source : https://github.com/smalot/bootstrap-datetimepicker


### Default usage

Name of type : `olix_datetimepicker`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('my_datetimepicker1', 'olix_datetimepicker');
    
    // With attributes
    $builder->add('my_datetimepicker2', 'olix_datetimepicker', array(
        'config' => array(
            'locale' => "fr",
            'format' => "dd/MM/yyyy HH:mm",
        )
    ));
}
```

### Options

#### locale
**type** : `string`, **default** : `%locale%`

Language, the two-letter code of the language to use for month and day names

#### format
**type** : `string`, **default** : `yyyy-mm-dd HH:ii`

The date format. This format is surcharged by the options `format` of options form symfony into format ICU

#### startDate
**type** : `string`, **default** : Beginning of time (format *yyyy-mm-dd hh:ii*)

The earliest date that may be selected; all earlier dates will be disabled

#### endDate
**type** : `string`, **default** : End of time (format *yyyy-mm-dd hh:ii*)

The latest date that may be selected; all later dates will be disabled.

#### todayBtn
**type** : `string` or `boolean`, **default** : `false`

If true, displays a "Today" button at the bottom of the datetimepicker to select the current date.
If true, the "Today" button will only move the current date into view

#### minuteStep
**type** : `integer` or `boolean`, **default** : `5`

The increment used to build the hour view

#### pickerPosition
**type** : `string`, **default** : `bottom-left`

This option is currently only available in the component implementation. With it you can place the picker just under the input field.

### Attributes

None