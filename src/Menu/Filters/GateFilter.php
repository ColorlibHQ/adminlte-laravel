<?php

namespace ColorlibHQ\AdminLte\Menu\Filters;

use Illuminate\Support\Facades\Gate;

/**
 * Removes menu items the current user isn't authorized to see.
 *
 * Honors the `can` key (a permission/ability string or array) and an optional
 * `can_params` model/argument passed to the gate.
 */
class GateFilter implements FilterInterface
{
    public function transform(array $item): ?array
    {
        if (! isset($item['can'])) {
            return $item;
        }

        // No authenticated gate available — leave item as-is.
        if (! class_exists(Gate::class)) {
            return $item;
        }

        $abilities = (array) $item['can'];
        $params = $item['can_params'] ?? [];

        foreach ($abilities as $ability) {
            if (Gate::allows($ability, $params)) {
                return $item;
            }
        }

        return null;
    }
}
