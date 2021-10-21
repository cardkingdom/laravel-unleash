<?php

namespace MikeFrancis\LaravelUnleash\Strategies\Contracts;

use Illuminate\Http\Request;

interface DynamicStrategy
{
    /**
     * @param array $params Strategy Configuration from Unleash
     * @param array $constraints Constraints from Unleash
     * @param Request $request Current Request
     * @param mixed $args An arbitrary number of arguments passed to isFeatureEnabled/Disabled
     * @return bool
     */
    public function isEnabled(array $params, array $constraints, Request $request, ...$args): bool;
}
