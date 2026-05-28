<?php declare(strict_types = 1);

// osfsl-/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/framework/src/Illuminate/View/Compilers/Concerns/CompilesLoops.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Illuminate\View\Compilers\Concerns\CompilesLoops
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-3d36a8d5a7eeb07b343bb5cce79341e433af6254902d9d454f4f44865259fa37-8.5.6-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/framework/src/Illuminate/View/Compilers/Concerns/CompilesLoops.php',
      ),
    ),
    'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
    'name' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
    'shortName' => 'CompilesLoops',
    'isInterface' => false,
    'isTrait' => true,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 7,
    'endLine' => 194,
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
      'forElseCounter' => 
      array (
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'name' => 'forElseCounter',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '0',
          'attributes' => 
          array (
            'startLine' => 14,
            'endLine' => 14,
            'startTokenPos' => 26,
            'startFilePos' => 263,
            'endTokenPos' => 26,
            'endFilePos' => 263,
          ),
        ),
        'docComment' => '/**
 * Counter to keep track of nested forelse statements.
 *
 * @var int
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 14,
        'endLine' => 14,
        'startColumn' => 5,
        'endColumn' => 34,
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
      'compileForelse' => 
      array (
        'name' => 'compileForelse',
        'parameters' => 
        array (
          'expression' => 
          array (
            'name' => 'expression',
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
            'startColumn' => 39,
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
 * Compile the for-else statements into valid PHP.
 *
 * @param  string|null  $expression
 * @return string
 *
 * @throws \\Illuminate\\Contracts\\View\\ViewCompilationException
 */',
        'startLine' => 24,
        'endLine' => 43,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileEmpty' => 
      array (
        'name' => 'compileEmpty',
        'parameters' => 
        array (
          'expression' => 
          array (
            'name' => 'expression',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 51,
            'endLine' => 51,
            'startColumn' => 37,
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
 * Compile the for-else-empty and empty statements into valid PHP.
 *
 * @param  string  $expression
 * @return string
 */',
        'startLine' => 51,
        'endLine' => 60,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileEndforelse' => 
      array (
        'name' => 'compileEndforelse',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Compile the end-for-else statements into valid PHP.
 *
 * @return string
 */',
        'startLine' => 67,
        'endLine' => 70,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileEndEmpty' => 
      array (
        'name' => 'compileEndEmpty',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Compile the end-empty statements into valid PHP.
 *
 * @return string
 */',
        'startLine' => 77,
        'endLine' => 80,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileFor' => 
      array (
        'name' => 'compileFor',
        'parameters' => 
        array (
          'expression' => 
          array (
            'name' => 'expression',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 88,
            'endLine' => 88,
            'startColumn' => 35,
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
 * Compile the for statements into valid PHP.
 *
 * @param  string  $expression
 * @return string
 */',
        'startLine' => 88,
        'endLine' => 91,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileForeach' => 
      array (
        'name' => 'compileForeach',
        'parameters' => 
        array (
          'expression' => 
          array (
            'name' => 'expression',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 101,
            'endLine' => 101,
            'startColumn' => 39,
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
 * Compile the for-each statements into valid PHP.
 *
 * @param  string|null  $expression
 * @return string
 *
 * @throws \\Illuminate\\Contracts\\View\\ViewCompilationException
 */',
        'startLine' => 101,
        'endLine' => 118,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileBreak' => 
      array (
        'name' => 'compileBreak',
        'parameters' => 
        array (
          'expression' => 
          array (
            'name' => 'expression',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 126,
            'endLine' => 126,
            'startColumn' => 37,
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
 * Compile the break statements into valid PHP.
 *
 * @param  string  $expression
 * @return string
 */',
        'startLine' => 126,
        'endLine' => 135,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileContinue' => 
      array (
        'name' => 'compileContinue',
        'parameters' => 
        array (
          'expression' => 
          array (
            'name' => 'expression',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 143,
            'endLine' => 143,
            'startColumn' => 40,
            'endColumn' => 50,
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
 * Compile the continue statements into valid PHP.
 *
 * @param  string  $expression
 * @return string
 */',
        'startLine' => 143,
        'endLine' => 152,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileEndfor' => 
      array (
        'name' => 'compileEndfor',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Compile the end-for statements into valid PHP.
 *
 * @return string
 */',
        'startLine' => 159,
        'endLine' => 162,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileEndforeach' => 
      array (
        'name' => 'compileEndforeach',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Compile the end-for-each statements into valid PHP.
 *
 * @return string
 */',
        'startLine' => 169,
        'endLine' => 172,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileWhile' => 
      array (
        'name' => 'compileWhile',
        'parameters' => 
        array (
          'expression' => 
          array (
            'name' => 'expression',
            'default' => NULL,
            'type' => NULL,
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 180,
            'endLine' => 180,
            'startColumn' => 37,
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
 * Compile the while statements into valid PHP.
 *
 * @param  string  $expression
 * @return string
 */',
        'startLine' => 180,
        'endLine' => 183,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'aliasName' => NULL,
      ),
      'compileEndwhile' => 
      array (
        'name' => 'compileEndwhile',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Compile the end-while statements into valid PHP.
 *
 * @return string
 */',
        'startLine' => 190,
        'endLine' => 193,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\View\\Compilers\\Concerns',
        'declaringClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'implementingClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
        'currentClassName' => 'Illuminate\\View\\Compilers\\Concerns\\CompilesLoops',
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