<?php

declare(strict_types = 1);
namespace Proclaim\Core;

class Component 
{
    public $data = null;
    public $name = null;

    function __construct( string $name, $data = null )
    {
        $this->name = $name;
        if( null !== $data)
            $this->data = $data;
    }
}