<?php

namespace Digitas\Rush\Twig\Extension;

use Twig_Extension;
use Digitas\Rush\Twig\NodeVisitor\Filler as NodeVisitor_Filler;

class Filler extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors()
    {
        return array(new NodeVisitor_Filler());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filler';
    }
}
