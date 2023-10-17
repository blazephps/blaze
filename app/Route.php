<?php

/**
 * |-------------------------|
 * | BlazePHP Router         |
 * |-------------------------|
 * | Copyright (C) 2023-2024 |
 * |                         |
 * |                         |
 * |-------------------------|
 */

use BlazePHP\Blaze\HTTP\Router;
use BlazePHP\Blaze\HTTP\Request;

$router = new Router();

$router->get("/", function () {
    view("index");
});

$router->run();