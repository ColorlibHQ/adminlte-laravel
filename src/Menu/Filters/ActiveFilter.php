<?php

namespace ColorlibHQ\AdminLte\Menu\Filters;

use Illuminate\Support\Facades\Request;

/**
 * Marks an item active when the current request URL matches its href or any of
 * its `active` patterns. Submenu parents become active if any child is active.
 */
class ActiveFilter implements FilterInterface
{
    /**
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>|null
     */
    public function transform(array $item): ?array
    {
        if (isset($item['submenu'])) {
            $item['submenu'] = array_map(
                fn (array $child) => $this->transform($child) ?? $child,
                $item['submenu']
            );

            // Parent is active if any child is.
            foreach ($item['submenu'] as $child) {
                if (! empty($child['active'])) {
                    $item['active'] = true;
                    break;
                }
            }
        }

        // Explicit boolean already set — respect it.
        if (isset($item['active']) && is_bool($item['active'])) {
            return $item;
        }

        $patterns = $item['active'] ?? [];

        // Auto-derive a pattern from the item's url when none given.
        if (empty($patterns) && isset($item['url']) && $item['url'] !== '#' && $item['url'] !== '/') {
            $patterns = [trim($item['url'], '/'), trim($item['url'], '/').'/*'];
        } elseif (empty($patterns) && (($item['url'] ?? null) === '/')) {
            $patterns = ['/'];
        }

        $item['active'] = $this->matchesAny((array) $patterns);

        return $item;
    }

    /**
     * @param  array<int, mixed>  $patterns
     */
    private function matchesAny(array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if ($pattern === '/' && Request::path() === '/') {
                return true;
            }
            if ($pattern !== '/' && Request::is($pattern)) {
                return true;
            }
        }

        return false;
    }
}
