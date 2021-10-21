<?php

namespace MikeFrancis\LaravelUnleash\Constraints\Contracts;

use Exception;
use Illuminate\Contracts\Config\Repository as Config;

trait ConstraintHelper
{
    /**
     * @property array $allConstraints
     */
    private $allConstraints;

    public function __construct(Config $config) {
        $this->allConstraints = $config->get('unleash.constraints', []);
    }

    /**
     * @throws Exception
     */
    public function validateConstraints(array $constraints): bool
    {
        foreach ($constraints as $constraint) {
            $context = $constraint['contextName'];

            if (!array_key_exists($context, $this->allConstraints)) {
                continue;
            }

            if (is_callable($this->allConstraints[$context])) {
                $constraintHandler = $this->allConstraints[$context]();
            } else {
                $constraintHandler = new $this->allConstraints[$context];
            }

            if (!$constraintHandler instanceof ConstraintHandler) {
                throw new Exception("${$context} does not implement base ConstraintHandler.");
            }

            $operator = $constraint['operator'];
            $values = $constraint['values'];
            if (!$constraintHandler->validateConstraint($operator, $values)) {
                return false;
            }
        }
        return true;
    }
}