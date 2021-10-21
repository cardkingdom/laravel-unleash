<?php

namespace MikeFrancis\LaravelUnleash\Constraints;

use Exception;
use Illuminate\Support\Facades\App;

class EnvironmentConstraintHandler implements Contracts\ConstraintHandler
{
    /**
     * @throws Exception
     */
    public function validateConstraint(string $operator, array $values): bool
    {
        if (!in_array($operator, Operators::ALL_OPERATORS)) {
            throw new Exception('Operator ' . $operator . ' is not one of ' . implode(',', Operators::ALL_OPERATORS));
        }

        $validEnvironment = App::environment($values);

        if ($operator == Operators::IN) {
            return $validEnvironment;
        } else {
            return !$validEnvironment;
        }
    }
}