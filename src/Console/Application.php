<?php
namespace Momo\Redmine\Console;

use Momo\Redmine\Config;
use Momo\Redmine\Console\Command\TicketCommentCommand;
use Momo\Redmine\Console\Command\PageKnockCommand;
use Momo\Redmine\Env;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Yaml\Yaml;

class Application extends ConsoleApplication
{
    protected $configYamlPath = null;

    protected $config = null;

    public function setConfigYamlPath($path)
    {
        $this->configYamlPath = $path;
    }

    public function getConfig()
    {
        if ($this->config === null) {
            $this->setUpConfig();
        }

        return $this->config;
    }

    protected function setUpConfig()
    {
        $env = new Env();
        $yaml = Yaml::parse(file_get_contents($this->configYamlPath));

        $this->config = new Config();
        $this->config->setRedmineRoot($yaml['redmine_root']);
        $this->config->setUsername($env->get('REDMINE_USERNAME'));
        $this->config->setPassword($env->get('REDMINE_PASSWORD'));

        if (is_array($yaml['knock'])) {
            $this->config->setKnockPages($yaml['knock']);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $commands = array_merge(parent::getDefaultCommands(), [
            new TicketCommentCommand(),
            new PageKnockCommand(),
        ]);

        return $commands;
    }
}
