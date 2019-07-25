<?php

namespace Zephir\Optimizers\FunctionCall;

use Zephir\Call;
use Zephir\CompilationContext;
use Zephir\CompiledExpression;
use Zephir\Compiler\CompilerException;
use Zephir\Optimizers\OptimizerAbstract;

class CRunfOptimizer extends OptimizerAbstract
{
    public function optimize(array $expression, Call $call, CompilationContext $context)
    {
        if (count($expression['parameters']) < 1) {
            throw new CompilerException("'c_runf' requires at least 2 parameters", $expression);
        }

        /**
         * Process the expected symbol to be returned
         */
        $call->processExpectedReturn($context);

        $resolvedParams = $call->getReadOnlyResolvedParams($expression['parameters'], $context, $expression);

        $expr = $expression['parameters'][1]['parameter']['value'];

        foreach ($resolvedParams as $k => $v) {
            if ($k === 1 || $k === 0) continue;
            $expr = str_replace('${' . ($k - 1) . '}', $v, $expr);
        }

        return new CompiledExpression(
            $expression['parameters'][0]['parameter']['value'],
            $expr,
            $expression
        );
    }
}
