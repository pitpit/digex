<?php

namespace Digitas\Rush\Twig\NodeVisitor;

use Twig_NodeVisitorInterface;
use Twig_NodeInterface;
use Twig_Environment;
use Twig_Node_Expression;
use Twig_Node_Body;
use Twig_Node;
use Twig_Node_Expression_TempName;
use Digitas\Rush\Twig\Node\FillerSetTemp;

/**
 * @author  Damien Pitard <damien.pitard@digitas.fr>
 * @author  Fabien Potencier <fabien@symfony.com>
 */
class Filler implements Twig_NodeVisitorInterface
{
    protected $prependedNodes = array();
    protected $inABody = false;

    /**
     * {@inheritdoc}
     */
    public function enterNode(Twig_NodeInterface $node, Twig_Environment $env)
    {
        if (!version_compare(phpversion(), '5.4.0RC1', '>=') && !$env->isStrictVariables()) {
            if ($this->inABody) {
                if (!$node instanceof Twig_Node_Expression) {
                    if (get_class($node) !== 'Twig_Node') {
                        array_unshift($this->prependedNodes, array());
                    }
                } else {
                    $node = $this->optimizeVariables($node, $env);
                }
            } elseif ($node instanceof Twig_Node_Body) {
                $this->inABody = true;
            }
        }

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function leaveNode(Twig_NodeInterface $node, Twig_Environment $env)
    {
        $expression = $node instanceof Twig_Node_Expression;

        // var_dump(get_class($node));

        if (!$env->isStrictVariables()) {
            if ($node instanceof Twig_Node_Body) {
                $this->inABody = false;
            } elseif ($this->inABody) {
                if (!$expression && get_class($node) !== 'Twig_Node' && $prependedNodes = array_shift($this->prependedNodes)) {

                    $nodes = array();
                    foreach (array_unique($prependedNodes) as $name) {
                        if (get_class($node) === 'Twig_Node_For') {
                            //$nodes[] = new FillerSetTemp($name, $node->getLine(), FillerSetTemp::HASH_TYPE);
                           // $nodes[] = $node;
                        } else {
                            $nodes[] = new FillerSetTemp($name, $node->getLine(), FillerSetTemp::STRING_TYPE);
                        }
                    }

                    $nodes[] = $node;
                    $node = new Twig_Node($nodes);
                }
            }
        }

        return $node;
    }

    protected function optimizeVariables($node, $env)
    {
        if ('Twig_Node_Expression_TempName' === get_class($node) ) {
            $this->prependedNodes[0][] = $node->getAttribute('name');

            //return new Twig_Node_Expression_TempName($node->getAttribute('name'), $node->getLine());
        }

        return $node;
    }


    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 256;
    }
}
