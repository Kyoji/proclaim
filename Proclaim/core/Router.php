<?php

declare(strict_types = 1);
namespace Proclaim\Core;

class Router
{
    protected $Proclaim;
    public $url;

    public function __construct( Proclaim &$Proclaim ) 
    {
        $this->Proclaim = $Proclaim;
        $this->formRouteArray();

        var_dump( $this->url );
    }

    protected function formRouteArray()
    {
        $url = $_SERVER['HTTPS'] ? 'https://' : 'http://';
        $url .= $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->url = \parse_url( $url );
        $this->url['is_https'] =  $_SERVER['HTTPS'] ? true : false;
        $this->url['path'] = \trim( $this->url['path'], "/" );
        $this->url['hierarchy'] = \explode("/", $this->url['path']);
    }


}