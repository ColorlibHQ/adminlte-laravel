<?php declare(strict_types = 1);

// osfsl-/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../orchestra/canvas/src/Console/FailedTableCommand.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Orchestra\Canvas\Console\FailedTableCommand
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-27560673cf315523ade56cb9ea2384ac291cbc13c9014e04ebc778cf2e6b138d-8.5.6-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../orchestra/canvas/src/Console/FailedTableCommand.php',
      ),
    ),
    'namespace' => 'Orchestra\\Canvas\\Console',
    'name' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
    'shortName' => 'FailedTableCommand',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Queue/Console/FailedTableCommand.php
 */',
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
            'code' => '\'make:queue-failed-table\'',
            'attributes' => 
            array (
              'startLine' => 11,
              'endLine' => 11,
              'startTokenPos' => 25,
              'startFilePos' => 284,
              'endTokenPos' => 25,
              'endFilePos' => 308,
            ),
          ),
          'description' => 
          array (
            'code' => '\'Create a migration for the failed queue jobs database table\'',
            'attributes' => 
            array (
              'startLine' => 11,
              'endLine' => 11,
              'startTokenPos' => 31,
              'startFilePos' => 324,
              'endTokenPos' => 31,
              'endFilePos' => 384,
            ),
          ),
          'aliases' => 
          array (
            'code' => '[\'queue:failed-table\']',
            'attributes' => 
            array (
              'startLine' => 11,
              'endLine' => 11,
              'startTokenPos' => 37,
              'startFilePos' => 396,
              'endTokenPos' => 39,
              'endFilePos' => 417,
            ),
          ),
        ),
      ),
    ),
    'startLine' => 11,
    'endLine' => 50,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Queue\\Console\\FailedTableCommand',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Orchestra\\Canvas\\Core\\Concerns\\MigrationGenerator',
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
    ),
    'immediateMethods' => 
    array (
      'configure' => 
      array (
        'name' => 'configure',
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
          0 => 
          array (
            'name' => 'Override',
            'isRepeated' => false,
            'arguments' => 
            array (
            ),
          ),
        ),
        'docComment' => '/**
 * Configures the current command.
 */',
        'startLine' => 19,
        'endLine' => 25,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
        'aliasName' => NULL,
      ),
      'createBaseMigration' => 
      array (
        'name' => 'createBaseMigration',
        'parameters' => 
        array (
          'table' => 
          array (
            'name' => 'table',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 34,
            'endLine' => 34,
            'startColumn' => 44,
            'endColumn' => 49,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
          0 => 
          array (
            'name' => 'Override',
            'isRepeated' => false,
            'arguments' => 
            array (
            ),
          ),
        ),
        'docComment' => '/**
 * Create a base migration file for the table.
 *
 * @param  string  $table
 * @return string
 */',
        'startLine' => 33,
        'endLine' => 37,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
        'aliasName' => NULL,
      ),
      'migrationExists' => 
      array (
        'name' => 'migrationExists',
        'parameters' => 
        array (
          'table' => 
          array (
            'name' => 'table',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 46,
            'endLine' => 46,
            'startColumn' => 40,
            'endColumn' => 45,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
          0 => 
          array (
            'name' => 'Override',
            'isRepeated' => false,
            'arguments' => 
            array (
            ),
          ),
        ),
        'docComment' => '/**
 * Determine whether a migration for the table already exists.
 *
 * @param  string  $table
 * @return bool
 */',
        'startLine' => 45,
        'endLine' => 49,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\FailedTableCommand',
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