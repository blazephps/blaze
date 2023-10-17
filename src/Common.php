<?php

/**
 * Common functions or variables are declared in this file
 *
 * Copyright (C) 2023-2024 BlazePHP // Hansen
 */


/**
 * Variables
 */

/**
 * Functions
 */

if (!function_exists("view")) {
    function view(string $file, array $data = []): string
    {
        $x = new \BlazePHP\Blaze\View\Render();
        $x->new($file, $data);
        return "";
    }
}