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

        // Auto-derive a pattern from where the item points when none is given.
        if (empty($patterns)) {
            $path = $this->pathOf($item);

            if ($path === '/') {
                $patterns = ['/'];
            } elseif ($path !== null) {
                $patterns = [$path, $path.'/*'];
            }
        }

        $item['active'] = $this->matchesAny((array) $patterns);

        return $item;
    }

    /**
     * The item's target as a path relative to the app root, or null when there
     * is nothing local to match against.
     *
     * This reads `href`, which HrefFilter has already resolved from `route` or
     * `url` — deriving the pattern from `url` alone would leave every
     * route-driven item permanently inactive, and resolving the route a second
     * time here would just be the same lookup twice.
     *
     * @param  array<string, mixed>  $item
     */
    private function pathOf(array $item): ?string
    {
        // A placeholder link points nowhere and must never match.
        if (($item['url'] ?? null) === '#') {
            return null;
        }

        $href = $item['href'] ?? $item['url'] ?? null;

        if (! is_string($href) || $href === '' || $href === '#') {
            return null;
        }

        $root = rtrim((string) url('/'), '/');

        if ($root !== '' && str_starts_with($href, $root)) {
            // Strip the app root so sub-directory installs still compare against
            // the same path Request::is() sees.
            $href = substr($href, strlen($root));
        } elseif (preg_match('#^(https?:)?//#', $href) || preg_match('#^[a-z][a-z0-9+.-]*:#i', $href)) {
            // Somewhere else entirely (or mailto:/tel:) — never the current page.
            return null;
        }

        $path = parse_url($href, PHP_URL_PATH);
        $path = is_string($path) ? trim($path, '/') : '';

        return $path === '' ? '/' : $path;
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
