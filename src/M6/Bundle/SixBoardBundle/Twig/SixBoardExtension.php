<?php

namespace M6\Bundle\SixBoardBundle\Twig;

class SixBoardExtension extends \Twig_Extension
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer::factory();
    }

    public function getFilters()
    {
        return array(
            'skriv_render' => new \Twig_Filter_Method($this, 'skrivRender'),
        );
    }

    public function skrivRender($string)
    {
        return $this->renderer->render($string);
    }

    public function getName()
    {
        return 'six_board_extension';
    }
}
