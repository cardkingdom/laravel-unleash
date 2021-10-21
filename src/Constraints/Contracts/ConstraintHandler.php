<?php

namespace MikeFrancis\LaravelUnleash\Constraints\Contracts;

interface ConstraintHandler
{
    public function validateConstraint(string $operator, array $values): bool;
}