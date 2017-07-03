<?php

declare(strict_types = 1);
namespace Proclaim\Core;

class Render
{
    protected $dir_prefix = "Proclaim/Templates/";
    protected $dir_base;
    protected $render_data;
    function __construct()
    {
        $this->dir_base = $_SERVER["DOCUMENT_ROOT"];
    }
    
    public function setData( array $data )
    {
        $this->render_data = $data;
    }
}

class RenderFactory
{
    public function newRender( $data = null )
    {
        $render = new Render( $data );
        return $render;
    }
}