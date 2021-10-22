<?php

namespace MikeFrancis\LaravelUnleash\Constraints;

use Exception;
use Illuminate\Support\Facades\App;

class EnvironmentConstraintHandler extends Contracts\ConstraintHandler
{
    /**
     * @throws Exception
     */
    public function validateConstraint(string $operator, array $values): bool
    {
        if (!in_array($operator, Operators::ALL_OPERATORS)) {
            throw new Exception('Operator ' . $operator . ' is not one of ' . implode(',', Operators::ALL_OPERATORS));
        }

        $environment = $this->config->get('unleash.featuresEndpoint');
        $isValid = in_array($environment, $values);

        if ($operator == Operators::IN) {
            return $isValid;
        } else {
            return !$isValid;
        }
    }
}