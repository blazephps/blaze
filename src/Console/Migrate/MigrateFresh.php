<?php

namespace BlazePHP\Blaze\Console\Migrate;

use BlazePHP\Blaze\Database\Migrator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateFresh extends Command
{
    protected function configure()
    {
        $this->setName('migrate:fresh')
            ->setDescription("Do a Fresh migrations to database");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<fg=bright-red>BlazePHP <fg=white>Migrating...");
        $cfg = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 3));
        $cfg->load();
        $m = new Migrator();
        $m->applyMigration("down", $output);
        $output->writeln("<fg=bright-red>BlazePHP <fg=white>Downed all Migrations!");
        $output->writeln("<fg=bright-red>BlazePHP <fg=white>Migrating...");
        $cfg = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 3));
        $cfg->load();
        $m = new Migrator();
        $m->applyMigration("up", $output);
        $output->writeln("<fg=bright-red>BlazePHP <fg=white>Applyed all Migrations!");
        return self::SUCCESS;
    }
}