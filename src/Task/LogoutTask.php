<?php

namespace Momo\Redmine\Task;

use Momo\Redmine\Config;
use Momo\Redmine\Http\Client;

class LogoutTask
{
    protected $config = null;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function execute(Client $client)
    {
        $uri = $this->config->getFullUri('/logout');

        $client->request('GET', $uri);
    }
}
