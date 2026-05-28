<?php declare(strict_types = 1);

// osfsl-/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/pail/src/Console/Commands/PailCommand.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Laravel\Pail\Console\Commands\PailCommand
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-dd0d6aa43da93e610724eab58a7d3d54f0f1bcd70b699eb9c5049474cd2dda90-8.5.6-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/pail/src/Console/Commands/PailCommand.php',
      ),
    ),
    'namespace' => 'Laravel\\Pail\\Console\\Commands',
    'name' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
    'shortName' => 'PailCommand',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
      0 => 
      array (
        'name' => 'Symfony\\Component\\Console\\Attribute\\AsCommand',
        'isRepeated' => false,
        'arguments' => 
        array (
          'name' => 
          array (
            'code' => '\'pail\'',
            'attributes' => 
            array (
              'startLine' => 17,
              'endLine' => 17,
              'startTokenPos' => 67,
              'startFilePos' => 473,
              'endTokenPos' => 67,
              'endFilePos' => 478,
            ),
          ),
        ),
      ),
    ),
    'startLine' => 17,
    'endLine' => 107,
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
        'declaringClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'implementingClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'name' => 'signature',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '\'pail
        {--filter= : Filter the logs by the given value}
        {--message= : Filter the logs by the given message}
        {--level= : Filter the logs by the given level}
        {--auth= : Filter the logs by the given authenticated ID}
        {--user= : Filter the logs by the given authenticated ID (alias for --auth)}
        {--timeout=3600 : The maximum execution time in seconds}\'',
          'attributes' => 
          array (
            'startLine' => 23,
            'endLine' => 29,
            'startTokenPos' => 89,
            'startFilePos' => 582,
            'endTokenPos' => 89,
            'endFilePos' => 976,
          ),
        ),
        'docComment' => '/**
 * {@inheritDoc}
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 23,
        'endLine' => 29,
        'startColumn' => 5,
        'endColumn' => 66,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'description' => 
      array (
        'declaringClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'implementingClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'name' => 'description',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '\'Tails the application logs\'',
          'attributes' => 
          array (
            'startLine' => 34,
            'endLine' => 34,
            'startTokenPos' => 100,
            'startFilePos' => 1046,
            'endTokenPos' => 100,
            'endFilePos' => 1073,
          ),
        ),
        'docComment' => '/**
 * {@inheritDoc}
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 34,
        'endLine' => 34,
        'startColumn' => 5,
        'endColumn' => 58,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'file' => 
      array (
        'declaringClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'implementingClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'name' => 'file',
        'modifiers' => 2,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
          'data' => 
          array (
            'types' => 
            array (
              0 => 
              array (
                'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                'data' => 
                array (
                  'name' => 'Laravel\\Pail\\File',
                  'isIdentifier' => false,
                ),
              ),
              1 => 
              array (
                'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                'data' => 
                array (
                  'name' => 'null',
                  'isIdentifier' => true,
                ),
              ),
            ),
          ),
        ),
        'default' => 
        array (
          'code' => 'null',
          'attributes' => 
          array (
            'startLine' => 39,
            'endLine' => 39,
            'startTokenPos' => 114,
            'startFilePos' => 1155,
            'endTokenPos' => 114,
            'endFilePos' => 1158,
          ),
        ),
        'docComment' => '/**
 * The file instance, if any.
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 39,
        'endLine' => 39,
        'startColumn' => 5,
        'endColumn' => 33,
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
          'processFactory' => 
          array (
            'name' => 'processFactory',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Laravel\\Pail\\ProcessFactory',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 44,
            'endLine' => 44,
            'startColumn' => 28,
            'endColumn' => 57,
            'parameterIndex' => 0,
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
        'docComment' => '/**
 * Handles the command execution.
 */',
        'startLine' => 44,
        'endLine' => 96,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Laravel\\Pail\\Console\\Commands',
        'declaringClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'implementingClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'currentClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'aliasName' => NULL,
      ),
      '__destruct' => 
      array (
        'name' => '__destruct',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Handles the object destruction.
 */',
        'startLine' => 101,
        'endLine' => 106,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Laravel\\Pail\\Console\\Commands',
        'declaringClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'implementingClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
        'currentClassName' => 'Laravel\\Pail\\Console\\Commands\\PailCommand',
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