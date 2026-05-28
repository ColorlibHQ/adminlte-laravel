<?php

namespace ColorlibHQ\AdminLte\Menu;

/**
 * Stateless helpers for classifying and inspecting menu items.
 */
class MenuItemHelper
{
    /**
     * Determine whether the item is a section header.
     */
    public static function isHeader(array $item): bool
    {
        return isset($item['header']);
    }

    /**
     * Determine whether the item is a link (has text + a destination).
     */
    public static function isLink(array $item): bool
    {
        return isset($item['text']) && ! self::isSearch($item);
    }

    /**
     * Determine whether the item is a search box.
     */
    public static function isSearch(array $item): bool
    {
        return isset($item['type']) && $item['type'] === 'navbar-search';
    }

    /**
     * Determine whether the item has a submenu (treeview).
     */
    public static function isSubmenu(array $item): bool
    {
        return isset($item['submenu']) && is_array($item['submenu']);
    }

    /**
     * Should the item appear in the sidebar? (Everything not flagged topnav-only.)
     */
    public static function isSidebarItem(array $item): bool
    {
        return empty($item['topnav']) && empty($item['topnav_right']);
    }

    /**
     * Should the item appear in the top navigation bar?
     */
    public static function isTopnavItem(array $item): bool
    {
        return ! empty($item['topnav']) || ! empty($item['topnav_right']);
    }

    /**
     * Is this item, or any of its descendants, currently active?
     */
    public static function isActive(array $item): bool
    {
        if (! empty($item['active'])) {
            return true;
        }

        if (self::isSubmenu($item)) {
            foreach ($item['submenu'] as $child) {
                if (self::isActive($child)) {
                    return true;
                }
            }
        }

        return false;
    }
}
