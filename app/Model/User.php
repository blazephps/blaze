<?php

namespace BlazePHP\App\Model;

use BlazePHP\Blaze\Database\Model;

class User
{
    use Model;

    public function __construct()
    {
        $this->setup("users");
    }
}