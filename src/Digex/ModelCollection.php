<?php

namespace Digex;

use Digex\ModelProviderInterface;

class ModelCollection
{
    protected $models = array();

    public function set($identifier, \Closure $closure)
    {
        $this->models[$identifier] = $closure;
    }

    public function get($identifier)
    {
        if (!isset($this->models[$identifier])) {
            throw new \Exception(sprintf('Unknown model "%s".', $identifier));
        }

        return call_user_func($this->models[$identifier]);
    }
}