<?php

declare(strict_types = 1);
namespace Proclaim\Core;

class Post 
{
    public $post_name;
    public $post_content;
    public $post_author;
    public $post_date;
    public $post_slug;
    public $ID;
    
    public function printName() {
        echo $this->post_name;
    }
    
    public function printContent() {
        echo $this->post_content;
    }
}