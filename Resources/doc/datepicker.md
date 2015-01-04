Composant Bootstrap-datetimepicker
==================================

Date picker widget based on twitter bootstrap

Demo : http://www.malot.fr/bootstrap-datetimepicker/

Source : https://github.com/smalot/bootstrap-datetimepicker


### Default usage

Name of type : `olix_datepicker`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('my_datepicker1', 'olix_datepicker');
    
    // With attributes
    $builder->add('my_datepicker2', 'olix_datepicker', array(
        'config' => array(
            'locale' => "fr",
            'format' => "dd/MM/yyyy",
        )
    ));
}
```

### Options

#### locale
**type** : `string`, **default** : `%locale%`

Language, the two-letter code of the language to use for month and day names

#### format
**type** : `string`, **default** : `yyyy-mm-dd`

The date format. This format is surcharged by the options `format` of options form symfony into format ICU

#### startDate
**type** : `string`, **default** : Beginning of time (format *yyyy-mm-dd*)

The earliest date that may be selected; all earlier dates will be disabled

#### endDate
**type** : `string`, **default** : End of time (format *yyyy-mm-dd*)

The latest date that may be selected; all later dates will be disabled.

#### todayBtn
**type** : `string` or `boolean`, **default** : `false`

If true, displays a "Today" button at the bottom of the datetimepicker to select the current date.
If true, the "Today" button will only move the current date into view


#### pickerPosition
**type** : `string`, **default** : `bottom-left`

This option is currently only available in the component implementation. With it you can place the picker just under the input field.

### Attributes

None