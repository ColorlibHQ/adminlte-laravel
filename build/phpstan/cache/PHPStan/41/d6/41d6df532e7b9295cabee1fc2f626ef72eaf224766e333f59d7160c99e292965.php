<?php declare(strict_types = 1);

// odsl-/Users/silkalns/Fresh Projects/adminlte-laravel/src/AdminLteServiceProvider.php-PHPStan\BetterReflection\Reflection\ReflectionClass-ColorlibHQ\AdminLte\AdminLteServiceProvider
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.70.0.1-8.5.6-1bd7ca4348187df523eea7452bc3cffb6653ac0cbd356663b40df24d07ef3536',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/src/AdminLteServiceProvider.php',
      ),
    ),
    'namespace' => 'ColorlibHQ\\AdminLte',
    'name' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
    'shortName' => 'AdminLteServiceProvider',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 14,
    'endLine' => 186,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Support\\ServiceProvider',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'components' => 
      array (
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'name' => 'components',
        'modifiers' => 4,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'default' => 
        array (
          'code' => '[\'card\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Card::class, \'info-box\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\InfoBox::class, \'small-box\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\SmallBox::class, \'alert\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Alert::class, \'callout\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Callout::class, \'progress\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Progress::class, \'timeline\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Timeline::class, \'progress-group\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\ProgressGroup::class, \'description-block\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\DescriptionBlock::class, \'profile-card\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\ProfileCard::class, \'ratings\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Ratings::class, \'nav-notifications\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\NavNotifications::class, \'nav-messages\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\NavMessages::class, \'nav-tasks\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\NavTasks::class, \'direct-chat\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\DirectChat::class, \'toast\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Toast::class, \'tabs\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Tabs::class, \'tab\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Tab::class, \'accordion\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Accordion::class, \'accordion-item\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\AccordionItem::class, \'breadcrumb\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Widget\\Breadcrumb::class, \'input\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Form\\Input::class, \'input-switch\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Form\\InputSwitch::class, \'input-color\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Form\\InputColor::class, \'input-file\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Form\\InputFile::class, \'input-flatpickr\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Form\\InputFlatpickr::class, \'input-tom-select\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Form\\InputTomSelect::class, \'textarea\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Form\\Textarea::class, \'select\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Form\\Select::class, \'button\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Form\\Button::class, \'modal\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\Modal::class, \'datatable\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\Datatable::class, \'editor\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\Editor::class, \'chart\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\Chart::class, \'vector-map\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\VectorMap::class, \'calendar\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\Calendar::class, \'kanban\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\Kanban::class, \'sortable\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\Sortable::class, \'wizard\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\Wizard::class, \'wizard-step\' => \\ColorlibHQ\\AdminLte\\View\\Components\\Tool\\WizardStep::class]',
          'attributes' => 
          array (
            'startLine' => 22,
            'endLine' => 63,
            'startTokenPos' => 67,
            'startFilePos' => 691,
            'endTokenPos' => 429,
            'endFilePos' => 2993,
          ),
        ),
        'docComment' => '/**
 * The Blade components shipped by the package, keyed by their tag alias.
 * Used as <x-adminlte-card>, <x-adminlte-small-box>, etc.
 *
 * @var array<string, class-string>
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 22,
        'endLine' => 63,
        'startColumn' => 5,
        'endColumn' => 6,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
    ),
    'immediateMethods' => 
    array (
      'register' => 
      array (
        'name' => 'register',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Register package services.
 */',
        'startLine' => 68,
        'endLine' => 88,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'ColorlibHQ\\AdminLte',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'aliasName' => NULL,
      ),
      'boot' => 
      array (
        'name' => 'boot',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Bootstrap package services.
 */',
        'startLine' => 93,
        'endLine' => 101,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'ColorlibHQ\\AdminLte',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'aliasName' => NULL,
      ),
      'registerComponents' => 
      array (
        'name' => 'registerComponents',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Register the package\'s Blade components under the `adminlte-` prefix.
 */',
        'startLine' => 106,
        'endLine' => 111,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'ColorlibHQ\\AdminLte',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'aliasName' => NULL,
      ),
      'registerBladeDirectives' => 
      array (
        'name' => 'registerBladeDirectives',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Register Blade directives for plugin management.
 */',
        'startLine' => 116,
        'endLine' => 141,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'ColorlibHQ\\AdminLte',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'aliasName' => NULL,
      ),
      'registerPublishing' => 
      array (
        'name' => 'registerPublishing',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Register publishable resources (config, views, frontend stubs).
 */',
        'startLine' => 146,
        'endLine' => 168,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'ColorlibHQ\\AdminLte',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'aliasName' => NULL,
      ),
      'registerCommands' => 
      array (
        'name' => 'registerCommands',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Register the package\'s artisan commands.
 */',
        'startLine' => 173,
        'endLine' => 185,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'ColorlibHQ\\AdminLte',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\AdminLteServiceProvider',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));