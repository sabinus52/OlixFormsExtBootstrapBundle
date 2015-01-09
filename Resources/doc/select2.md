Composant Select2
=================

Select2 is a jQuery based replacement for select boxes.

Demo : http://select2.github.io/select2/

Source : https://github.com/select2/select2


### Default usage

Name of type :
* `olix_select2_choice`
* `olix_select2_entity`
* `olix_select2_country`
* `olix_select2_language`
* `olix_select2_locale`
* `olix_select2_timezone`
* `olix_select2_currency`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('my_select1', 'olix_select2_country', array(
        'empty_value' => '',
        'config' => array(
            'placeholder' => "Selectionner un pays",
            'allowClear' => true,
        ),
    );
    
    // Entity
    $builder->add('my_select2', 'olix_select2_entity', array(
        'empty_value' => '',
        'class' => 'AcmeHelloBundle:User',
        'property' => 'username',
        'config' => array(
            'allowClear' => true,
        )
    ));
}
```

### Options

#### placeholder
**type** : `string`, **default** : 

Initial value that is selected if no other selection is made.

#### allowClear
**type** : `boolean`, **default** : `false`

Whether or not a clear button is displayed when the select box has a selection.

#### minimumInputLength
**type** : `int`, **default** : `2`

Number of characters necessary to start a search.

#### Others options
See http://select2.github.io/select2/ for the list

### Attributes

None

## Method 1 : Query

Name of type `olix_select2_hidden`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('my_select', 'olix_select2_hidden', array(
        'empty_value' => '',
        'config' => array(
            minimumInputLength => 1,
        ),
        'query' => 'fctQueryTest', // Name of function javascript
    );
    
}
```
Then you'll have to customize the javascript template in your view :
``` html
<!-- In your block javascript -->
{% block javascript %}
{{ form_javascript(form) }}
<script type="text/javascript">
function fctQueryTest (query) {
    var data = {results: []}, i, j, s;
    for (i = 1; i < 5; i++) {
        s = "";
        for (j = 0; j < i; j++) {s = s + query.term;}
        data.results.push({id: query.term + i, text: s});
    }
    query.callback(data);
}
</script>
{% endblock %}
```

## Method 2 : Ajax simple mode

Name of type `olix_select2_hidden`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('country', 'olix_select2_hidden', array(
        'config' => array(
            'placeholder' => "Select a country",
            'allowClear' => true,
            'minimumInputLength' => 1,
        ),
        'ajax' => array(
            'url' => 'route_ajax_countries' // Name of route for results into ajax
            'dataType' => 'json, // Value xml, json by default
            'quietMillis' => 250, // Number of milliseconds to wait for the user to stop typing before issuing the ajax request
            'cache' => false, // If set to false, it will force requested pages not to be cached by the browser
        ),
    );
}
```

``` php
// In controller

/**
 * @Route("/ajax/countries", name="route_ajax_countries")
 */
public function ajaxCountriesAction()
{
    $em = $this->getDoctrine()->getManager();
    $request = $this->getRequest();
    $query = $request->query->get('q'); // Parameter of search
    
    $query = $em->createQuery('
        SELECT a 
        FROM MyBundle:Country a
        WHERE a.name LIKE :name'
    )->setParameter('name', "$query%");
    $countries = array();
    foreach ($query->getResult() as $country) {
        $countries[] = array(
            'id'   => $country->getId(),
            'text' => $country->getName(),
        );
    }
    $result = array('more' => false, 'results' => $countries); // Data for select2
    return new JsonResponse($result);
}
```


## Method 3 : Ajax advanced mode

Name of type `olix_select2_hidden`

``` php
// In class form

public function buildForm(FormBuilder $builder, array $options)
{
    $builder->add('country', 'olix_select2_hidden', array(
        'config' => array(
            'placeholder' => "Select a country",
            'allowClear' => true,
            'minimumInputLength' => 1,
        ),
    );
}
```
Then you'll have to customize the javascript template in your view :

``` html
<!-- In your view -->

{% form_theme form _self %}

{% block olix_select2_hidden_javascript %}

    <script type="text/javascript">
        var $config = {{ config|json_encode|raw }};

        // custom configs
        $configs = $.extend($config, {
            ajax: {
                url: "{{ path('otop_demo_demo_clients_ajax_countries') }}",
                dataType: "json",
                quietMillis: 250,
                cache: true,
                data: function (term, page) {
                    return { q: term };
                },
                results: function (data, page) {
                    return { results: data.results };
                }
            },
            initSelection : function (element, callback) {
                var data = {id: element.val(), text: element.val(), code: element.val()};
                callback(data);
            },
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function (m) { return m; }
        });
        // end of custom configs

        $('#{{ id }}').select2($config);

        function format(item) {
            return "<img class='flag' src='images/flags/" + item.code.toLowerCase() + ".png' />" + item.text;
        }
    </script>

{% endblock %}
```