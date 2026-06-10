<?php

namespace ColorlibHQ\AdminLte;

use ColorlibHQ\AdminLte\Menu\MenuItemHelper;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Builds and filters the AdminLTE menu from configuration.
 *
 * Resolve via the container (singleton) or the `adminlte` alias:
 *
 *     app('adminlte')->menu('sidebar');
 */
class AdminLte
{
    /**
     * The raw menu definition from config (plus any runtime additions).
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $menu = [];

    /**
     * The filtered menu, cached per scope after first build.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $filteredMenu = [];

    /**
     * @param  array<int, array<string, mixed>>  $menu
     */
    public function __construct(
        array $menu,
        protected Dispatcher $events,
        protected Container $container,
    ) {
        $this->menu = $menu;
    }

    /**
     * Insert items into the menu at runtime (e.g. from a service provider),
     * directly after the item whose `key`, `text` or `header` matches
     * $itemKey. Falls back to appending when no item matches.
     *
     * @param  array<string, mixed>  ...$items
     */
    public function addAfter(string $itemKey, array ...$items): void
    {
        $index = $this->findIndex($itemKey);

        if ($index === null) {
            array_push($this->menu, ...$items);
        } else {
            array_splice($this->menu, $index + 1, 0, $items);
        }

        $this->filteredMenu = [];
    }

    /**
     * Append items to the end of the menu at runtime.
     *
     * @param  array<string, mixed>  ...$items
     */
    public function add(array ...$items): void
    {
        array_push($this->menu, ...$items);
        $this->filteredMenu = [];
    }

    /**
     * Locate a top-level menu item by its `key`, `text` or `header` value.
     */
    protected function findIndex(string $itemKey): ?int
    {
        foreach ($this->menu as $index => $item) {
            foreach (['key', 'text', 'header'] as $attribute) {
                if (($item[$attribute] ?? null) === $itemKey) {
                    return $index;
                }
            }
        }

        return null;
    }

    /**
     * Get the processed menu for a scope: 'sidebar', 'navbar-left',
     * 'navbar-right', or null for the full filtered list.
     *
     * @return array<int, array<string, mixed>>
     */
    public function menu(?string $scope = null): array
    {
        if (empty($this->filteredMenu)) {
            $this->filteredMenu = $this->buildFiltered();
        }

        return match ($scope) {
            'sidebar' => array_values(array_filter(
                $this->filteredMenu,
                fn ($item) => MenuItemHelper::isSidebarItem($item)
            )),
            'navbar-left' => array_values(array_filter(
                $this->filteredMenu,
                fn ($item) => ! empty($item['topnav'])
            )),
            'navbar-right' => array_values(array_filter(
                $this->filteredMenu,
                fn ($item) => ! empty($item['topnav_right'])
            )),
            default => $this->filteredMenu,
        };
    }

    /**
     * Run every configured filter across every menu item, dropping nulls.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function buildFiltered(): array
    {
        $filters = array_map(
            fn (string $class) => $this->container->make($class),
            config('adminlte.filters', [])
        );

        $result = [];

        foreach ($this->menu as $item) {
            foreach ($filters as $filter) {
                $item = $filter->transform($item);
                if ($item === null) {
                    continue 2; // item filtered out entirely
                }
            }
            $result[] = $item;
        }

        return $result;
    }
}
