# Twital for PHPTransformers

[Twital](https://github.com/goetas/twital) support for [PHPTransformers](http://github.com/phptransformers/phptransformer).

## Install

Via Composer

``` bash
$ composer require macfja/phptransformer-twital
```

## Usage

``` php
$engine = new TwitalTransformer();
echo $engine->render('Hello, {{ name }}!', array('name' => 'phptransformers');
```

### Special case for string rendering (`render`)

If you are using `TwitalTransformer` to render template stored in a string variable, you need to indicate to Twital plugin the type of
string you are about to use (HTML5, XML, XHTML).  
To do so you can pass a _magic_ parameter to the `render` function.
The parameter is named `__twital-adapter` and its value is an instance of `\Goetas\Twital\SourceAdapter`

``` php
$engine = new TwitalTransformer();
echo $engine->render(
    '<ul t:if="users">
        <li t:for="user in users">
            {{ user.name }}
        </li>
    </ul>',
    array(
        'users' => array(
            array('name' => 'phptransformers'),
            array('name' => 'twig'),
            array('name' => 'twital')
        ),
        '__twital-adapter' => new HTML5Adapter()
    )
);
```

## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.