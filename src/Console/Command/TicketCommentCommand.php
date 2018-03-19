<?php
namespace Momo\Redmine\Console\Command;

use Momo\Redmine\Http\Client;
use Momo\Redmine\Task\LoginTask;
use Momo\Redmine\Task\LogoutTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class TicketCommentCommand extends Command
{
    protected $config = null;

    protected function configure()
    {
        $this
            ->setName('ticket:comment')
            ->setDescription('')
            ->setDefinition([
                new InputArgument('issueId', InputArgument::REQUIRED, 'issue id', null),
                new InputArgument('comment', InputArgument::REQUIRED, 'comment text', null),
            ]);
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

        $uri = $this->config->getFullUri(sprintf('/issues/%d', $input->getArgument('issueId')));

        $crawler = $client->request('GET', $uri);

        $form = $crawler->filter('#issue-form')->form();
        $form->setValues([
            'issue[notes]' => $input->getArgument('comment'),
        ]);

        $client->submit($form);

        $logoutTask = new LogoutTask($this->config);
        $logoutTask->execute($client);
    }
}
