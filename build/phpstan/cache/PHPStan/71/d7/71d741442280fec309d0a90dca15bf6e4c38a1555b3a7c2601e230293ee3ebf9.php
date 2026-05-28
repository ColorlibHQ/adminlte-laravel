<?php declare(strict_types = 1);

// osfsl-/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../orchestra/canvas/src/Console/ComponentMakeCommand.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Orchestra\Canvas\Console\ComponentMakeCommand
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-3a45bbac00124537afb9659bb7faee6e7b7c33e75fe6179e5e5b7538fec88afa-8.5.6-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../orchestra/canvas/src/Console/ComponentMakeCommand.php',
      ),
    ),
    'namespace' => 'Orchestra\\Canvas\\Console',
    'name' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
    'shortName' => 'ComponentMakeCommand',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Foundation/Console/ComponentMakeCommand.php
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
            'code' => '\'make:component\'',
            'attributes' => 
            array (
              'startLine' => 13,
              'endLine' => 13,
              'startTokenPos' => 35,
              'startFilePos' => 395,
              'endTokenPos' => 35,
              'endFilePos' => 410,
            ),
          ),
          'description' => 
          array (
            'code' => '\'Create a new view component class\'',
            'attributes' => 
            array (
              'startLine' => 13,
              'endLine' => 13,
              'startTokenPos' => 41,
              'startFilePos' => 426,
              'endTokenPos' => 41,
              'endFilePos' => 460,
            ),
          ),
        ),
      ),
    ),
    'startLine' => 13,
    'endLine' => 89,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Foundation\\Console\\ComponentMakeCommand',
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
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
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
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'aliasName' => NULL,
      ),
      'afterCodeHasBeenGenerated' => 
      array (
        'name' => 'afterCodeHasBeenGenerated',
        'parameters' => 
        array (
          'className' => 
          array (
            'name' => 'className',
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
            'startLine' => 48,
            'endLine' => 48,
            'startColumn' => 47,
            'endColumn' => 63,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'path' => 
          array (
            'name' => 'path',
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
            'startLine' => 48,
            'endLine' => 48,
            'startColumn' => 66,
            'endColumn' => 77,
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
        'docComment' => '/**
 * Run after code successfully generated.
 */',
        'startLine' => 48,
        'endLine' => 53,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
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
            'startLine' => 62,
            'endLine' => 62,
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
        'startLine' => 61,
        'endLine' => 65,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
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
        'startLine' => 72,
        'endLine' => 76,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'aliasName' => NULL,
      ),
      'viewPath' => 
      array (
        'name' => 'viewPath',
        'parameters' => 
        array (
          'path' => 
          array (
            'name' => 'path',
            'default' => 
            array (
              'code' => '\'\'',
              'attributes' => 
              array (
                'startLine' => 85,
                'endLine' => 85,
                'startTokenPos' => 276,
                'startFilePos' => 2080,
                'endTokenPos' => 276,
                'endFilePos' => 2081,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 85,
            'endLine' => 85,
            'startColumn' => 33,
            'endColumn' => 42,
            'parameterIndex' => 0,
            'isOptional' => true,
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
 * Get the first view directory path from the application configuration.
 *
 * @param  string  $path
 * @return string
 */',
        'startLine' => 84,
        'endLine' => 88,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ComponentMakeCommand',
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