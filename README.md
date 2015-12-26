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

## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.