<?php

namespace ColorlibHQ\AdminLte\Menu\Filters;

/**
 * Normalizes navbar-search items, ensuring they carry a method and placeholder.
 */
class SearchFilter implements FilterInterface
{
    public function transform(array $item): ?array
    {
        if (($item['type'] ?? null) !== 'navbar-search') {
            return $item;
        }

        $item['method'] = $item['method'] ?? 'get';
        $item['placeholder'] = $item['placeholder'] ?? 'Search';
        $item['url'] = $item['url'] ?? '#';

        return $item;
    }
}
