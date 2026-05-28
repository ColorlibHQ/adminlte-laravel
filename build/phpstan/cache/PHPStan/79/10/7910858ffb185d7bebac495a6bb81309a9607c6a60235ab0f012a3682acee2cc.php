<?php declare(strict_types = 1);

// osfsl-/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../orchestra/canvas/src/Console/ControllerMakeCommand.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Orchestra\Canvas\Console\ControllerMakeCommand
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-93d48b617d19c33e6a51cade961e19f668c1bc413639414552f3028d28b5d069-8.5.6-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../orchestra/canvas/src/Console/ControllerMakeCommand.php',
      ),
    ),
    'namespace' => 'Orchestra\\Canvas\\Console',
    'name' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
    'shortName' => 'ControllerMakeCommand',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Routing/Console/ControllerMakeCommand.php
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
            'code' => '\'make:controller\'',
            'attributes' => 
            array (
              'startLine' => 13,
              'endLine' => 13,
              'startTokenPos' => 35,
              'startFilePos' => 393,
              'endTokenPos' => 35,
              'endFilePos' => 409,
            ),
          ),
          'description' => 
          array (
            'code' => '\'Create a new controller class\'',
            'attributes' => 
            array (
              'startLine' => 13,
              'endLine' => 13,
              'startTokenPos' => 41,
              'startFilePos' => 425,
              'endTokenPos' => 41,
              'endFilePos' => 455,
            ),
          ),
        ),
      ),
    ),
    'startLine' => 13,
    'endLine' => 184,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Routing\\Console\\ControllerMakeCommand',
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
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
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
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'aliasName' => NULL,
      ),
      'qualifyModel' => 
      array (
        'name' => 'qualifyModel',
        'parameters' => 
        array (
          'model' => 
          array (
            'name' => 'model',
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
            'startColumn' => 37,
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
 * Qualify the given model class base name.
 *
 * @return string
 */',
        'startLine' => 50,
        'endLine' => 54,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'aliasName' => NULL,
      ),
      'buildParentReplacements' => 
      array (
        'name' => 'buildParentReplacements',
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
 * Build the replacements for a parent controller.
 *
 * @return array
 */',
        'startLine' => 61,
        'endLine' => 84,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'aliasName' => NULL,
      ),
      'buildModelReplacements' => 
      array (
        'name' => 'buildModelReplacements',
        'parameters' => 
        array (
          'replace' => 
          array (
            'name' => 'replace',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 92,
            'endLine' => 92,
            'startColumn' => 47,
            'endColumn' => 60,
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
 * Build the model replacement values.
 *
 * @return array
 */',
        'startLine' => 91,
        'endLine' => 121,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
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
            'startLine' => 130,
            'endLine' => 130,
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
        'startLine' => 129,
        'endLine' => 133,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
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
        'startLine' => 140,
        'endLine' => 144,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'aliasName' => NULL,
      ),
      'findAvailableModels' => 
      array (
        'name' => 'findAvailableModels',
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
 * Get a list of possible model names.
 *
 * @return array<int, string>
 */',
        'startLine' => 151,
        'endLine' => 155,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'aliasName' => NULL,
      ),
      'generateFormRequests' => 
      array (
        'name' => 'generateFormRequests',
        'parameters' => 
        array (
          'modelClass' => 
          array (
            'name' => 'modelClass',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 166,
            'endLine' => 166,
            'startColumn' => 45,
            'endColumn' => 55,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'storeRequestClass' => 
          array (
            'name' => 'storeRequestClass',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 166,
            'endLine' => 166,
            'startColumn' => 58,
            'endColumn' => 75,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'updateRequestClass' => 
          array (
            'name' => 'updateRequestClass',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 166,
            'endLine' => 166,
            'startColumn' => 78,
            'endColumn' => 96,
            'parameterIndex' => 2,
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
 * Generate the form requests for the given model and classes.
 *
 * @param  string  $modelClass
 * @param  string  $storeRequestClass
 * @param  string  $updateRequestClass
 * @return array
 */',
        'startLine' => 165,
        'endLine' => 183,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Orchestra\\Canvas\\Console',
        'declaringClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'implementingClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
        'currentClassName' => 'Orchestra\\Canvas\\Console\\ControllerMakeCommand',
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