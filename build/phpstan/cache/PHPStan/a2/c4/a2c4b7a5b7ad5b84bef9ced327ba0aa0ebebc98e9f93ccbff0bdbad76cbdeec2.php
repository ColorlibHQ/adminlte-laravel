<?php declare(strict_types = 1);

// osfsl-/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../orchestra/canvas/src/Console/ListenerMakeCommand.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Orchestra\Canvas\Console\ListenerMakeCommand
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-39479ab160bf73f1a02ca19eeb4be7a1fba12a0d0461f38eddd08cd345a2179e-8.5.6-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../orchestra/canvas/src/Console/ListenerMakeCommand.php',
      ),
    ),
    'namespace' => 'Orchestra\\Canvas\\Console',
    'name' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
    'shortName' => 'ListenerMakeCommand',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Foundation/Console/ListenerMakeCommand.php
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
            'code' => '\'make:listener\'',
            'attributes' => 
            array (
              'startLine' => 13,
              'endLine' => 13,
              'startTokenPos' => 35,
              'startFilePos' => 394,
              'endTokenPos' => 35,
              'endFilePos' => 408,
            ),
          ),
          'description' => 
          array (
            'code' => '\'Create a new event listener class\'',
            'attributes' => 
            array (
              'startLine' => 13,
              'endLine' => 13,
              'startTokenPos' => 41,
              'startFilePos' => 424,
              'endTokenPos' => 41,
              'endFilePos' => 458,
            ),
          ),
        ),
      ),
    ),
    'startLine' => 13,
    'endLine' => 78,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Foundation\\Console\\ListenerMakeCommand',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Orchestra\\Canvas\\Core\\Concerns\\CodeGenerator',
      1 => 'Orchestra\\Canvas\\Core\\Concerns\\TestGenerator',
      2 => 'Orchestra\\Canvas\\Core\\Concerns\\UsesGeneratorOverrides',
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
        'startLine' => 23,
        'endLine' => 29,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'aliasName' => NULL,
      ),
      'handle' => 
      array (
        'name' => 'handle',
        'parameters' => 
        array (
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
 * Execute the console command.
 *
 * @return bool|null
 *
 * @throws \\Illuminate\\Contracts\\Filesystem\\FileNotFoundException
 */',
        'startLine' => 38,
        'endLine' => 43,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'aliasName' => NULL,
      ),
      'getPath' => 
      array (
        'name' => 'getPath',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 52,
            'endLine' => 52,
            'startColumn' => 32,
            'endColumn' => 36,
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
 * Get the destination class path.
 *
 * @param  string  $name
 * @return string
 */',
        'startLine' => 51,
        'endLine' => 55,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'aliasName' => NULL,
      ),
      'rootNamespace' => 
      array (
        'name' => 'rootNamespace',
        'parameters' => 
        array (
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
 * Get the root namespace for the class.
 *
 * @return string
 */',
        'startLine' => 62,
        'endLine' => 66,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'aliasName' => NULL,
      ),
      'possibleEvents' => 
      array (
        'name' => 'possibleEvents',
        'parameters' => 
        array (
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
 * Get a list of possible event names.
 *
 * @return array<int, string>
 */',
        'startLine' => 73,
        'endLine' => 77,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ListenerMakeCommand',
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