<?php declare(strict_types = 1);

// odsl-/Users/silkalns/Fresh Projects/adminlte-laravel/src/Console/InstallCommand.php-PHPStan\BetterReflection\Reflection\ReflectionClass-ColorlibHQ\AdminLte\Console\InstallCommand
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.70.0.1-8.5.6-fa52c67b85d51a4794f225381d616034369ecb265611467ea27c6c5cb94a88fb',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/src/Console/InstallCommand.php',
      ),
    ),
    'namespace' => 'ColorlibHQ\\AdminLte\\Console',
    'name' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
    'shortName' => 'InstallCommand',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 9,
    'endLine' => 111,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Console\\Command',
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
      'signature' => 
      array (
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'name' => 'signature',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '\'adminlte:install
        {--only= : Install only a specific resource (config|views|assets)}
        {--force : Overwrite existing files}
        {--no-interaction-deps : Skip the npm install prompt}\'',
          'attributes' => 
          array (
            'startLine' => 11,
            'endLine' => 14,
            'startTokenPos' => 38,
            'startFilePos' => 223,
            'endTokenPos' => 38,
            'endFilePos' => 422,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 11,
        'endLine' => 14,
        'startColumn' => 5,
        'endColumn' => 63,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'description' => 
      array (
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'name' => 'description',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '\'Install the AdminLTE 4 scaffolding (config, Vite assets, frontend deps).\'',
          'attributes' => 
          array (
            'startLine' => 16,
            'endLine' => 16,
            'startTokenPos' => 47,
            'startFilePos' => 455,
            'endTokenPos' => 47,
            'endFilePos' => 528,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 16,
        'endLine' => 16,
        'startColumn' => 5,
        'endColumn' => 104,
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
      'handle' => 
      array (
        'name' => 'handle',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'int',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 18,
        'endLine' => 49,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'ColorlibHQ\\AdminLte\\Console',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'aliasName' => NULL,
      ),
      'publishTag' => 
      array (
        'name' => 'publishTag',
        'parameters' => 
        array (
          'tag' => 
          array (
            'name' => 'tag',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 51,
            'endLine' => 51,
            'startColumn' => 33,
            'endColumn' => 43,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'label' => 
          array (
            'name' => 'label',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 51,
            'endLine' => 51,
            'startColumn' => 46,
            'endColumn' => 58,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
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
        'docComment' => NULL,
        'startLine' => 51,
        'endLine' => 62,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'ColorlibHQ\\AdminLte\\Console',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'aliasName' => NULL,
      ),
      'wireVite' => 
      array (
        'name' => 'wireVite',
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
 * Add admin-lte + bootstrap imports to the published stubs if not present,
 * and make sure they\'re referenced by Vite. We don\'t rewrite the user\'s
 * vite.config.js automatically — we print guidance instead, to avoid
 * clobbering custom configs.
 */',
        'startLine' => 70,
        'endLine' => 88,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'ColorlibHQ\\AdminLte\\Console',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'aliasName' => NULL,
      ),
      'installFrontendDependencies' => 
      array (
        'name' => 'installFrontendDependencies',
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
        'docComment' => NULL,
        'startLine' => 90,
        'endLine' => 110,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'ColorlibHQ\\AdminLte\\Console',
        'declaringClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'implementingClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
        'currentClassName' => 'ColorlibHQ\\AdminLte\\Console\\InstallCommand',
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