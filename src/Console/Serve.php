<?php

namespace BlazePHP\Blaze\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Serve extends Command
{
    protected function configure()
    {
        $this->setName('serve')
            ->setDescription("Start the application");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<fg=bright-red>BlazePHP <fg=white>Starting server...");
        $output->writeln("<fg=bright-red>BlazePHP <fg=white>Started local server on http://localhost:8000");
        exec("php -S localhost:8000 -t public");

        return self::SUCCESS;
    }
}