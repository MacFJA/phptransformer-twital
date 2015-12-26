<?php

namespace MacFJA\PhpTransformer\Twital;

use Goetas\Twital\TwitalLoader;
use PhpTransformers\PhpTransformer\TransformerInterface;

/**
 * Class TwitalTransformer.
 *
 * The PhpTransformer for Twital Twig plugin.
 * {@link https://github.com/goetas/twital/}
 *
 * @author  MacFJA
 * @package MacFJA\PhpTransformer\Twital
 * @license MIT
 */
class TwitalTransformer implements TransformerInterface
{
    /** @var \Twig_Environment  */
    protected $environment;
    /** @var TwitalLoader|\Twig_Loader_String */
    protected $stringLoader;

    /**
     * The transformer constructor.
     *
     * Options are:
     *   - "twig" a \Twig_Environment instance
     * if the option "twig" is not provided, the array will be passed to the
     * \Twig_Environment constructor
     *
     * @param array $options The TwitalTransformer options
     */
    public function __construct(array $options = array())
    {
        $this->stringLoader = new TwitalLoader(new \Twig_Loader_String());
        if (array_key_exists('twig', $options)) {
            $this->environment = $options['twig'];
        } else {
            $this->environment = new \Twig_Environment(
                new TwitalLoader(new \Twig_Loader_Filesystem(getcwd())),
                $options
            );
        }
    }

    /**
     * Get the transformer name
     *
     * @return string
     */
    public function getName()
    {
        return 'twital';
    }

    /**
     * Render a file
     *
     * @param string $file The file to render
     * @param array $locals The variable to use in template
     * @return null|string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderFile($file, array $locals = array())
    {
        return $this->environment->render($file, $locals);
    }

    /**
     * Render a string
     *
     * A special option in the $locals array can be used to define the Twital adapter to use.
     * The array key is `__twital-adapter`, and the value is an instance of `\Goetas\Twital\SourceAdapter`
     *
     * @param string $template The template content to render
     * @param array $locals The variable to use in template
     * @return null|string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render($template, array $locals = array())
    {
        if (array_key_exists('__twital-adapter', $locals)) {
            $this->stringLoader->addSourceAdapter('/.*/', $locals['__twital-adapter']);
        }
        // Render the file using the straight string.
        $this->environment->setLoader($this->stringLoader);

        return $this->environment->render($template, $locals);
    }
}
