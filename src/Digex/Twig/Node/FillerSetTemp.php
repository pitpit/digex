<?php

namespace Digitas\Rush\Twig\Node;

use Twig_Node;
use Twig_Compiler;

class FillerSetTemp extends Twig_Node
{
    const STRING_TYPE = 0;
    const HASH_TYPE = 1;

    protected $type;


    public function __construct($name, $lineno, $type)
    {
        $this->type = $type;
        parent::__construct(array(), array('name' => $name), $lineno);
    }

    public function compile(Twig_Compiler $compiler)
    {
        $name = $this->getAttribute('name');
        $compiler
            ->addDebugInfo($this)
            ->write('if (isset($context[')
            ->string($name)
            ->raw('])) { $_')
            ->raw($name)
            ->raw('_ = $context[')
            ->repr($name)
            ->raw(']; } else { $_')
            ->raw($name)
            ->raw("_ = ");

        if (self::STRING_TYPE === $this->type) {
            $compiler->raw("'{{ ")->raw($name)->raw(" }}'");
        } else if (self::HASH_TYPE === $this->type) {

            $compiler->raw("array(");

            $max = rand(3, 6);
            for ($i = 0; $i < $max; $i++) {
                if ($i > 0) {
                    $compiler->raw(', ');
                }
                $compiler->raw("'{{ ")->raw($name)->raw(".$i }}'");
            }
            $compiler->raw(")");
        } else {
            throw new \Exception('Unknown type.');
        }

        $compiler->write("; }\n");
    }

}
