<?php

namespace Zephir\Optimizers\FunctionCall;

use Zephir\Call;
use Zephir\CompilationContext;
use Zephir\CompiledExpression;
use Zephir\Compiler\CompilerException;
use Zephir\Optimizers\OptimizerAbstract;

class CCallOptimizer extends OptimizerAbstract
{
    public function optimize(array $expression, Call $call, CompilationContext $context)
    {

        if (count($expression['parameters']) < 2) {
            throw new CompilerException("'c_call' requires at least 2 parameters", $expression);
        }

        /**
         * Process the expected symbol to be returned
         */
        $call->processExpectedReturn($context);

        $resolvedParams = $call->getReadOnlyResolvedParams($expression['parameters'], $context, $expression);

        $args = [];

        foreach ($expression['parameters'] as $k => $v) {
            if ($k === 0 || $k === 1 || $k % 2) continue;
            $l = $resolvedParams[$k + 1];
            switch ($v['parameter']['value']) {
                case 'double':
                case 'float':
                    $args[] = "Z_DVAL_P($l)";
                    break;
                case 'long':
                case 'int':
                    $args[] = "Z_LVAL_P($l)";
                    break;
                case 'string':
                    $args[] = "Z_STRVAL_P($l)";
                    break;
                default:
                    throw new CompilerException("'c_call' received a wrong type", $expression);
            }
        }

        $args = join(", ", $args);

        return new CompiledExpression(
            $expression['parameters'][0]['parameter']['value'],
            "{$expression['parameters'][1]['parameter']['value']}($args)",
            $expression
        );
    }
}
