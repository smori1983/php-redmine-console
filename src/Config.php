<?php

namespace Momo\Redmine;

class Config
{
    protected $redmineRoot = null;

    protected $username = null;
    protected $password = null;

    protected $knockPages = [];

    public function setRedmineRoot($root)
    {
        $this->redmineRoot = $root;
    }

    public function getRedmineRoot()
    {
        return $this->redmineRoot;
    }

    public function getFullUri($relativePath)
    {
        return sprintf('%s/%s', rtrim($this->redmineRoot, '/'), ltrim($relativePath, '/'));
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setKnockPages(array $pages)
    {
        $this->knockPages = $pages;
    }

    public function getKnockPages()
    {
        return $this->knockPages;
    }
}
