<?php

namespace Momo\Redmine\Console\Command;

use Momo\Redmine\Http\Client;
use Momo\Redmine\Task\LoginTask;
use Momo\Redmine\Task\LogoutTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PageKnockCommand extends Command
{
    protected $config = null;

    protected function configure()
    {
        $this
            ->setName('page:knock')
            ->setDescription('')
            ->setDefinition([]);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->config = $this->getApplication()->getConfig();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();

        $loginTask = new LoginTask($this->config);
        $loginTask->execute($client);

        foreach ($this->config->getKnockPages() as $page) {
            $uri = $this->config->getFullUri($page);

            $output->writeln(sprintf('<info>knock: %s</info>', $uri));

            $client->request('GET', $uri);
        }

        $logoutTask = new LogoutTask($this->config);
        $logoutTask->execute($client);
    }
}
