<?php
declare(strict_types=1);
require_once __DIR__ . "/../vendor/autoload.php";

\Dotenv\Dotenv::createImmutable(dirname(__DIR__))->load();

require_once __DIR__ . "/../src/Common.php";
require_once __DIR__ . "/../app/Route.php";