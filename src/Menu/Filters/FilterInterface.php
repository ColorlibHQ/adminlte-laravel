<?php

namespace ColorlibHQ\AdminLte\Menu\Filters;

interface FilterInterface
{
    /**
     * Transform a single menu item. Return the (possibly modified) item, or
     * null to remove it from the menu entirely.
     */
    public function transform(array $item): ?array;
}
