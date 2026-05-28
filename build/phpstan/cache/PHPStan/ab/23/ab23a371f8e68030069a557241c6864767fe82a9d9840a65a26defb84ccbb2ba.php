<?php declare(strict_types = 1);

// osfsl-/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/framework/src/Illuminate/View/Compilers/Concerns/CompilesEchos.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Illuminate\View\Compilers\Concerns\CompilesEchos
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-0b1e7428a18688d0d920cfffc386400047703caa382f4a876272c914080bbaaf-8.5.6-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/framework/src/Illuminate/View/Compilers/Concerns/CompilesEchos.php',
      ),
    ),
    'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
    'name' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
    'shortName' => 'CompilesEchos',
    'isInterface' => false,
    'isTrait' => true,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 8,
    'endLine' => 171,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
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
      'echoHandlers' => 
      array (
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'name' => 'echoHandlers',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[]',
          'attributes' => 
          array (
            'startLine' => 15,
            'endLine' => 15,
            'startTokenPos' => 31,
            'startFilePos' => 254,
            'endTokenPos' => 32,
            'endFilePos' => 255,
          ),
        ),
        'docComment' => '/**
 * Custom rendering callbacks for stringable objects.
 *
 * @var array
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 15,
        'endLine' => 15,
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
      'stringable' => 
      array (
        'name' => 'stringable',
        'parameters' => 
        array (
          'class' => 
          array (
            'name' => 'class',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 24,
            'endLine' => 24,
            'startColumn' => 32,
            'endColumn' => 37,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'handler' => 
          array (
            'name' => 'handler',
            'default' => 
            array (
              'code' => 'null',
              'attributes' => 
              array (
                'startLine' => 24,
                'endLine' => 24,
                'startTokenPos' => 50,
                'startFilePos' => 496,
                'endTokenPos' => 50,
                'endFilePos' => 499,
              ),
            ),
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 24,
            'endLine' => 24,
            'startColumn' => 40,
            'endColumn' => 54,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add a handler to be executed before echoing a given class.
 *
 * @param  string|callable  $class
 * @param  callable|null  $handler
 * @return void
 */',
        'startLine' => 24,
        'endLine' => 31,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'aliasName' => NULL,
      ),
      'compileEchos' => 
      array (
        'name' => 'compileEchos',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 39,
            'endLine' => 39,
            'startColumn' => 34,
            'endColumn' => 39,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Compile Blade echos into valid PHP.
 *
 * @param  string  $value
 * @return string
 */',
        'startLine' => 39,
        'endLine' => 46,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'aliasName' => NULL,
      ),
      'getEchoMethods' => 
      array (
        'name' => 'getEchoMethods',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the echo methods in the proper order for compilation.
 *
 * @return array
 */',
        'startLine' => 53,
        'endLine' => 60,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'aliasName' => NULL,
      ),
      'compileRawEchos' => 
      array (
        'name' => 'compileRawEchos',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 68,
            'endLine' => 68,
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
        ),
        'docComment' => '/**
 * Compile the "raw" echo statements.
 *
 * @param  string  $value
 * @return string
 */',
        'startLine' => 68,
        'endLine' => 81,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'aliasName' => NULL,
      ),
      'compileRegularEchos' => 
      array (
        'name' => 'compileRegularEchos',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 89,
            'endLine' => 89,
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
        ),
        'docComment' => '/**
 * Compile the "regular" echo statements.
 *
 * @param  string  $value
 * @return string
 */',
        'startLine' => 89,
        'endLine' => 102,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'aliasName' => NULL,
      ),
      'compileEscapedEchos' => 
      array (
        'name' => 'compileEscapedEchos',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 110,
            'endLine' => 110,
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
        ),
        'docComment' => '/**
 * Compile the escaped echo statements.
 *
 * @param  string  $value
 * @return string
 */',
        'startLine' => 110,
        'endLine' => 123,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'aliasName' => NULL,
      ),
      'addBladeCompilerVariable' => 
      array (
        'name' => 'addBladeCompilerVariable',
        'parameters' => 
        array (
          'result' => 
          array (
            'name' => 'result',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 131,
            'endLine' => 131,
            'startColumn' => 49,
            'endColumn' => 55,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Add an instance of the blade echo handler to the start of the compiled string.
 *
 * @param  string  $result
 * @return string
 */',
        'startLine' => 131,
        'endLine' => 134,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'aliasName' => NULL,
      ),
      'wrapInEchoHandler' => 
      array (
        'name' => 'wrapInEchoHandler',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 142,
            'endLine' => 142,
            'startColumn' => 42,
            'endColumn' => 47,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Wrap the echoable value in an echo handler if applicable.
 *
 * @param  string  $value
 * @return string
 */',
        'startLine' => 142,
        'endLine' => 151,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'aliasName' => NULL,
      ),
      'applyEchoHandler' => 
      array (
        'name' => 'applyEchoHandler',
        'parameters' => 
        array (
          'value' => 
          array (
            'name' => 'value',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 159,
            'endLine' => 159,
            'startColumn' => 38,
            'endColumn' => 43,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Apply the echo handler for the value if it exists.
 *
 * @param  string  $value
 * @return string
 */',
        'startLine' => 159,
        'endLine' => 170,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesEchos',
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