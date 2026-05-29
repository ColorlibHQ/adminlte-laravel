<?php

use ColorlibHQ\AdminLte\Menu\Filters\ActiveFilter;
use ColorlibHQ\AdminLte\Menu\Filters\GateFilter;
use ColorlibHQ\AdminLte\Menu\Filters\HrefFilter;
use ColorlibHQ\AdminLte\Menu\Filters\SearchFilter;

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default page title, and an optional prefix/postfix applied to every
    | page title set with @section('title', ...).
    |
    */

    'title' => 'AdminLTE 4',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | AdminLTE 4 uses Source Sans 3. Set to false to self-host or skip.
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | The brand logo shown in the sidebar. `logo` accepts HTML.
    |
    */

    'logo' => '<b>Admin</b>LTE',
    'logo_img' => 'vendor/adminlte/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image opacity-75 shadow',
    'logo_img_alt' => 'AdminLTE Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication logo
    |--------------------------------------------------------------------------
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User menu (topbar dropdown)
    |--------------------------------------------------------------------------
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Body-level layout switches. These map directly to AdminLTE 4 body classes.
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,   // .layout-fixed
    'layout_fixed_navbar' => true,    // .fixed-header
    'layout_fixed_footer' => null,    // .fixed-footer
    'layout_dark_mode' => null,       // null = respect system / user toggle
    'layout_rtl' => false,            // Enable right-to-left layout

    /*
    |--------------------------------------------------------------------------
    | Footer & Preloader
    |--------------------------------------------------------------------------
    */

    'footer_left' => 'Copyright &copy; 2014-'.date('Y').' <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>. All rights reserved.',
    'footer_right' => 'Anything you want',
    'preloader' => false,
    'control_sidebar' => false,
    'control_sidebar_theme' => 'dark',

    // "View documentation" CTA button at the bottom of the sidebar (false to hide).
    'sidebar_docs_url' => 'https://adminlte.io/themes/v4/docs/introduction.html',

    // Bundled demo/showcase pages (Dashboard v2/v3, Widgets, UI, Forms, Tables,
    // Layout Options, Theme Generate, auth variants, error pages). Set false to
    // skip registering their routes in production.
    'demo' => true,
    'demo_middleware' => ['web', 'auth'],

    'sidebar_breakpoint' => 'lg',     // sidebar-expand-{breakpoint}
    'sidebar_mini' => true,           // .sidebar-mini
    'sidebar_collapse' => false,      // start collapsed
    'sidebar_collapse_auto_size' => false,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'leave',

    /*
    |--------------------------------------------------------------------------
    | Color theme
    |--------------------------------------------------------------------------
    |
    | The sidebar uses data-bs-theme="dark" by default (dark sidebar on a
    | light page, matching the AdminLTE 4 demos). Set to 'light' for a light
    | sidebar.
    |
    */

    'sidebar_theme' => 'dark',  // 'dark' | 'light'

    /*
    |--------------------------------------------------------------------------
    | Custom body / element classes
    |--------------------------------------------------------------------------
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => 'fw-light',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'bg-body-secondary shadow',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-expand bg-body',
    'classes_topnav_nav' => 'navbar',
    'classes_topnav_container' => 'container-fluid',

    /*
    |--------------------------------------------------------------------------
    | Color mode toggle
    |--------------------------------------------------------------------------
    |
    | Shows the Light/Dark/Auto dropdown in the topbar (AdminLTE 4 feature).
    |
    */

    'color_mode_toggle' => true,

    /*
    |--------------------------------------------------------------------------
    | Menu
    |--------------------------------------------------------------------------
    |
    | The sidebar (and optional top-nav) menu. Each item is an array. Supported
    | keys:
    |
    |   'header'      => 'SECTION LABEL'            // a section header
    |   'text'        => 'Dashboard'               // link label (required for links)
    |   'route'       => 'dashboard'               // named route  -> url
    |   'url'         => 'admin/users'             // raw url (relative or absolute)
    |   'icon'        => 'bi bi-speedometer'       // Bootstrap Icons class
    |   'icon_color'  => 'primary'                 // optional text-{color}
    |   'label'       => 5                         // badge value
    |   'label_color' => 'primary'                 // badge color
    |   'active'      => ['admin/users*']          // url patterns that mark active
    |   'target'      => '_blank'                  // anchor target
    |   'can'         => 'view-users'              // gate/permission to show item
    |   'submenu'     => [ ...child items... ]     // nested items (treeview)
    |
    */

    'menu' => [
        // ---- Sidebar: mirrors the AdminLTE 4 demo sidebar ----
        [
            'text' => 'Dashboard',
            'icon' => 'bi bi-speedometer',
            'submenu' => [
                ['text' => 'Dashboard v1', 'url' => '/', 'icon' => 'bi bi-circle'],
                ['text' => 'Dashboard v2', 'url' => 'demo/dashboard-v2', 'icon' => 'bi bi-circle'],
                ['text' => 'Dashboard v3', 'url' => 'demo/dashboard-v3', 'icon' => 'bi bi-circle'],
            ],
        ],
        [
            'text' => 'Theme Generate',
            'url' => 'demo/theme-generator',
            'icon' => 'bi bi-palette',
        ],
        [
            'text' => 'Widgets',
            'icon' => 'bi bi-box-seam-fill',
            'submenu' => [
                ['text' => 'Small Box', 'url' => 'demo/widgets/small-box', 'icon' => 'bi bi-circle'],
                ['text' => 'Info Box', 'url' => 'demo/widgets/info-box', 'icon' => 'bi bi-circle'],
                ['text' => 'Cards', 'url' => 'demo/widgets/cards', 'icon' => 'bi bi-circle'],
            ],
        ],
        [
            'text' => 'Layout Options',
            'url' => 'demo/layout-options',
            'icon' => 'bi bi-clipboard-fill',
        ],
        [
            'text' => 'UI Elements',
            'icon' => 'bi bi-tree-fill',
            'submenu' => [
                ['text' => 'General', 'url' => 'demo/ui/general', 'icon' => 'bi bi-circle'],
                ['text' => 'Icons', 'url' => 'demo/ui/icons', 'icon' => 'bi bi-circle'],
                ['text' => 'Timeline', 'url' => 'demo/ui/timeline', 'icon' => 'bi bi-circle'],
            ],
        ],
        [
            'text' => 'Mailbox',
            'icon' => 'bi bi-envelope',
            'submenu' => [
                ['text' => 'Inbox', 'url' => 'admin/mailbox', 'icon' => 'bi bi-circle'],
                ['text' => 'Compose', 'url' => 'admin/mailbox/compose', 'icon' => 'bi bi-circle'],
            ],
        ],
        [
            'text' => 'Forms',
            'icon' => 'bi bi-pencil-square',
            'submenu' => [
                ['text' => 'Elements', 'url' => 'demo/forms/elements', 'icon' => 'bi bi-circle'],
                ['text' => 'Layout', 'url' => 'demo/forms/layout', 'icon' => 'bi bi-circle'],
                ['text' => 'Validation', 'url' => 'demo/forms/validation', 'icon' => 'bi bi-circle'],
                ['text' => 'Wizard', 'url' => 'demo/forms/wizard', 'icon' => 'bi bi-circle'],
            ],
        ],
        [
            'text' => 'Tables',
            'icon' => 'bi bi-table',
            'submenu' => [
                ['text' => 'Simple Tables', 'url' => 'demo/tables/simple', 'icon' => 'bi bi-circle'],
                ['text' => 'Data Tables', 'url' => 'demo/tables/data', 'icon' => 'bi bi-circle'],
            ],
        ],

        ['header' => 'PAGES'],
        [
            'text' => 'Pages',
            'icon' => 'bi bi-file-earmark-text',
            'submenu' => [
                ['text' => 'Profile', 'url' => 'admin/profile', 'icon' => 'bi bi-circle'],
                ['text' => 'Settings', 'url' => 'admin/settings', 'icon' => 'bi bi-circle'],
                ['text' => 'Invoice', 'url' => 'admin/invoice', 'icon' => 'bi bi-circle'],
                ['text' => 'Calendar', 'url' => 'admin/calendar', 'icon' => 'bi bi-circle'],
                ['text' => 'Kanban', 'url' => 'admin/kanban', 'icon' => 'bi bi-circle'],
                ['text' => 'Chat', 'url' => 'admin/chat', 'icon' => 'bi bi-circle'],
                ['text' => 'File Manager', 'url' => 'admin/file-manager', 'icon' => 'bi bi-circle'],
                ['text' => 'Projects', 'url' => 'admin/projects', 'icon' => 'bi bi-circle'],
                ['text' => 'Pricing', 'url' => 'admin/pricing', 'icon' => 'bi bi-circle'],
                ['text' => 'FAQ', 'url' => 'admin/faq', 'icon' => 'bi bi-circle'],
                [
                    'text' => 'Error',
                    'icon' => 'bi bi-circle',
                    'submenu' => [
                        ['text' => '404', 'url' => 'demo/errors/404', 'icon' => 'bi bi-circle'],
                        ['text' => '500', 'url' => 'demo/errors/500', 'icon' => 'bi bi-circle'],
                        ['text' => 'Maintenance', 'url' => 'demo/errors/maintenance', 'icon' => 'bi bi-circle'],
                    ],
                ],
            ],
        ],

        ['header' => 'EXAMPLES'],
        [
            'text' => 'Auth',
            'icon' => 'bi bi-box-arrow-in-right',
            'submenu' => [
                [
                    'text' => 'Version 1',
                    'icon' => 'bi bi-box-arrow-in-right',
                    'submenu' => [
                        ['text' => 'Login', 'url' => 'login', 'icon' => 'bi bi-circle'],
                        ['text' => 'Register', 'url' => 'register', 'icon' => 'bi bi-circle'],
                    ],
                ],
                [
                    'text' => 'Version 2',
                    'icon' => 'bi bi-box-arrow-in-right',
                    'submenu' => [
                        ['text' => 'Login', 'url' => 'demo/auth/login-v2', 'icon' => 'bi bi-circle'],
                        ['text' => 'Register', 'url' => 'demo/auth/register-v2', 'icon' => 'bi bi-circle'],
                        ['text' => 'Lockscreen', 'url' => 'demo/auth/lockscreen', 'icon' => 'bi bi-circle'],
                    ],
                ],
            ],
        ],

        ['header' => 'MULTI LEVEL EXAMPLE'],
        ['text' => 'Level 1', 'url' => '#', 'icon' => 'bi bi-circle-fill'],
        [
            'text' => 'Level 1',
            'icon' => 'bi bi-circle-fill',
            'submenu' => [
                ['text' => 'Level 2', 'url' => '#', 'icon' => 'bi bi-circle'],
                [
                    'text' => 'Level 2',
                    'icon' => 'bi bi-circle',
                    'submenu' => [
                        ['text' => 'Level 3', 'url' => '#', 'icon' => 'bi bi-record-circle-fill'],
                        ['text' => 'Level 3', 'url' => '#', 'icon' => 'bi bi-record-circle-fill'],
                        ['text' => 'Level 3', 'url' => '#', 'icon' => 'bi bi-record-circle-fill'],
                    ],
                ],
                ['text' => 'Level 2', 'url' => '#', 'icon' => 'bi bi-circle'],
            ],
        ],
        ['text' => 'Level 1', 'url' => '#', 'icon' => 'bi bi-circle-fill'],

        ['header' => 'LABELS'],
        ['text' => 'Important', 'url' => '#', 'icon' => 'bi bi-circle', 'icon_color' => 'danger'],
        ['text' => 'Warning', 'url' => '#', 'icon' => 'bi bi-circle', 'icon_color' => 'warning'],
        ['text' => 'Informational', 'url' => '#', 'icon' => 'bi bi-circle', 'icon_color' => 'info'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu filters
    |--------------------------------------------------------------------------
    |
    | Filters transform each menu item before rendering. Add your own classes
    | here (must implement ColorlibHQ\AdminLte\Menu\Filters\FilterInterface).
    | The defaults handle gates, active state, hrefs, and search items.
    |
    */

    'filters' => [
        GateFilter::class,
        HrefFilter::class,
        ActiveFilter::class,
        SearchFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    |
    | Optional JavaScript libraries integrated with AdminLTE 4. Disable plugins
    | you don't use to avoid loading unnecessary assets.
    |
    */

    'plugins' => [
        'flatpickr' => [
            'enabled' => false,
            'css' => 'vendor/flatpickr/flatpickr.min.css',
            'js' => 'vendor/flatpickr/flatpickr.min.js',
        ],
        'tom_select' => [
            'enabled' => false,
            'css' => 'vendor/tom-select/tom-select.bootstrap5.min.css',
            'js' => 'vendor/tom-select/tom-select.complete.min.js',
        ],
        'tabulator' => [
            'enabled' => false,
            'css' => 'vendor/tabulator-tables/tabulator.min.css',
            'js' => 'vendor/tabulator-tables/tabulator.min.js',
        ],
        'quill' => [
            'enabled' => false,
            'css' => 'vendor/quill/quill.snow.css',
            'js' => 'vendor/quill/quill.min.js',
        ],
        'apexcharts' => [
            'enabled' => false,
            'js' => 'vendor/apexcharts/apexcharts.min.js',
        ],
        'jsvectormap' => [
            'enabled' => false,
            'css' => 'vendor/jsvectormap/jsvectormap.min.css',
            // The library first, then the world map data (registers the 'world' map).
            'js' => [
                'vendor/jsvectormap/jsvectormap.min.js',
                'vendor/jsvectormap/maps/world.js',
            ],
        ],
        'fullcalendar' => [
            'enabled' => false,
            'js' => 'vendor/fullcalendar/index.global.min.js',
        ],
        'sortablejs' => [
            'enabled' => false,
            'js' => 'vendor/sortablejs/sortablejs.min.js',
        ],
    ],

];
