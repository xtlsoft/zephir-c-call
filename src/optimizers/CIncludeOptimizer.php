<?php

namespace Zephir\Optimizers\FunctionCall;

use Zephir\Call;
use Zephir\CompilationContext;
use Zephir\CompiledExpression;
use Zephir\Compiler\CompilerException;
use Zephir\Optimizers\OptimizerAbstract;

class CIncludeOptimizer extends OptimizerAbstract
{
    public function optimize(array $expression, Call $call, CompilationContext $context)
    {
        if (count($expression['parameters']) !== 1) {
            throw new CompilerException("'c_runf' requires 1 parameter", $expression);
        }

        try {
            throw new \Exception("h");
        } catch (\Exception $e) {
            die(var_dump(
                $e->getTraceAsString()
            ));
        }
        /**
         * Process the expected symbol to be returned
         */
        $call->processExpectedReturn($context);

        return new CompiledExpression(
            "bool",
            "#include \"{$expression['parameters'][0]['parameter']['value']}\"",
            $expression
        );
    }
}
