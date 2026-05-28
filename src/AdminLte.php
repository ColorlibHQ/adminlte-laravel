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
     * @var array<int, array>
     */
    protected array $menu = [];

    /**
     * The filtered menu, cached per scope after first build.
     *
     * @var array<string, array>
     */
    protected array $filteredMenu = [];

    public function __construct(
        array $menu,
        protected Dispatcher $events,
        protected Container $container,
    ) {
        $this->menu = $menu;
    }

    /**
     * Append items to the menu at runtime (e.g. from a service provider).
     */
    public function addAfter(string $itemKey, array ...$items): void
    {
        // Simplest useful runtime hook: append to the end. (A fuller
        // implementation could splice relative to $itemKey.)
        array_push($this->menu, ...$items);
        $this->filteredMenu = [];
    }

    /**
     * Get the processed menu for a scope: 'sidebar', 'navbar-left',
     * 'navbar-right', or null for the full filtered list.
     *
     * @return array<int, array>
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
     * @return array<int, array>
     */
    protected function buildFiltered(): array
    {
        $filters = array_map(
            fn (string $class) => $this->container->make($class),
            $this->container['config']['adminlte.filters'] ?? []
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
