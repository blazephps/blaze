<?php

namespace BlazePHP\Blaze\Console;

use BlazePHP\Blaze\Console\Migrate\Migrate;
use BlazePHP\Blaze\Console\Migrate\MigrateDown;
use BlazePHP\Blaze\Console\Migrate\MigrateFresh;
use Symfony\Component\Console\Application;

class CLI
{
    /**
     * @throws \Exception
     */
    public static function init(): void
    {
        $app = new Application("Blaze CLI", "1.0.0");

        $app->add(new Serve());
        $app->add(new Migrate());
        $app->add(new MigrateDown());
        $app->add(new MigrateFresh());

        $app->run();
    }
}