<?php

namespace MikeFrancis\LaravelUnleash\Constraints\Contracts;

use Exception;
use Illuminate\Contracts\Config\Repository as Config;

trait ConstraintHelper
{
    /**
     * @property Config $config
     */
    private $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }

    /**
     * @throws Exception
     */
    public function validateConstraints(array $constraints): bool
    {
        $allConstraints = $this->config->get('unleash.constraints', []);
        foreach ($constraints as $constraint) {
            $context = $constraint['contextName'];

            if (!array_key_exists($context, $allConstraints)) {
                continue;
            }

            if (is_callable($allConstraints[$context])) {
                $constraintHandler = $allConstraints[$context]($this->config);
            } else {
                $constraintHandler = new $allConstraints[$context]($this->config);
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