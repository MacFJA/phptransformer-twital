<?php

namespace MacFJA\PhpTransformer\Test\Twital;


use Goetas\Twital\SourceAdapter\XMLAdapter;
use Goetas\Twital\TwitalLoader;
use \MacFJA\PhpTransformer\Twital\TwitalTransformer;

class TwitalTransformerTest extends \PHPUnit_Framework_TestCase
{
    protected $generatedTemplate = '<?xml version="1.0"?>
<root>
    <book><![CDATA[Book 1]]></book>
    <book><![CDATA[Book 2]]></book>
</root>';
    protected $data = array('Book 1','Book 2');

    public function testGetName()
    {
        $engine = new TwitalTransformer();
        $this->assertEquals('twital', $engine->getName());
    }

    public function testRenderFile()
    {
        $engine = new TwitalTransformer();

        $expected = $this->removeWhiteSpace($this->generatedTemplate);
        $actual = $this->removeWhiteSpace($engine->renderFile('tests/Fixtures/template.twital.xml', array('names' => $this->data)));

        $this->assertEquals($expected, $actual);
    }

    protected function removeWhiteSpace($input)
    {
        $output = new \DOMDocument();
        $output->preserveWhiteSpace = false;
        $output->formatOutput = false;
        $output->loadXML($input);
        return $output->saveXML();
    }

    public function testRender()
    {
        $engine = new TwitalTransformer();

        $expected = $this->removeWhiteSpace($this->generatedTemplate);
        $actual = $this->removeWhiteSpace($engine->render(
            file_get_contents('tests/Fixtures/template.twital.xml'),
            array(
                'names' => $this->data,
                '__twital-adapter' => new XMLAdapter()
            )
        ));

        $this->assertEquals($expected, $actual);
    }

    public function testConstructor()
    {
        $loader = new TwitalLoader(new \Twig_Loader_Filesystem(__DIR__.'/Fixtures'));
        $twig = new \Twig_Environment($loader);

        $engine = new TwitalTransformer(array('twig' => $twig));

        $expected = $this->removeWhiteSpace($this->generatedTemplate);
        $actual = $this->removeWhiteSpace($engine->renderFile('template.twital.xml', array('names' => $this->data)));

        $this->assertEquals($expected, $actual);
    }


}
