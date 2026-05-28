<?php

namespace ColorlibHQ\AdminLte\Menu\Filters;

/**
 * Resolves each item's final `href` from `route` or `url`, and recurses into
 * submenus. An item with neither resolves to "#".
 */
class HrefFilter implements FilterInterface
{
    public function transform(array $item): ?array
    {
        if (isset($item['submenu'])) {
            $item['submenu'] = array_map(
                fn (array $child) => $this->transform($child) ?? $child,
                $item['submenu']
            );
        }

        // Headers and search boxes don't need an href.
        if (isset($item['header']) || (($item['type'] ?? null) === 'navbar-search')) {
            return $item;
        }

        if (isset($item['href'])) {
            return $item;
        }

        if (isset($item['route'])) {
            $item['href'] = is_array($item['route'])
                ? route($item['route'][0], $item['route'][1] ?? [])
                : route($item['route']);

            return $item;
        }

        if (isset($item['url'])) {
            $item['href'] = $this->isExternal($item['url'])
                ? $item['url']
                : url($item['url']);

            return $item;
        }

        $item['href'] = '#';

        return $item;
    }

    private function isExternal(string $url): bool
    {
        return (bool) preg_match('#^(https?:)?//#', $url) || str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:');
    }
}
