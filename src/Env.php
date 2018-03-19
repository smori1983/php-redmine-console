<?php
namespace Momo\Redmine;

class Env
{
    public function get($key)
    {
        $value = getenv($key);

        if ($value === false) {
            throw new \RuntimeException(sprintf('The env key not found: %s', $key));
        }

        return $value;
    }
}
