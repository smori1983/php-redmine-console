<?php
namespace Momo\Redmine\Task;

use Momo\Redmine\Config;
use Momo\Redmine\Http\Client;

class LoginTask
{
    protected $config = null;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function execute(Client $client)
    {
        $uri = $this->config->getFullUri('/login');

        $crawler = $client->request('GET', $uri);

        $form = $crawler->filter('#login-form form')->form();
        $form->setValues([
            'username' => $this->config->getUsername(),
            'password' => $this->config->getPassword(),
        ]);

        $client->submit($form);
    }
}
