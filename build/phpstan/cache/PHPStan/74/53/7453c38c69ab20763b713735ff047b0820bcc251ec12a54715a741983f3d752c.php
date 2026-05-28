<?php declare(strict_types = 1);

// osfsl-/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/framework/src/Illuminate/Foundation/Console/DownCommand.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Illuminate\Foundation\Console\DownCommand
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-0d17b6a838a4f33de657d4d578b3328c35493fb4f510269bf78115a2e0b036a3-8.5.6-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/framework/src/Illuminate/Foundation/Console/DownCommand.php',
      ),
    ),
    'namespace' => 'Illuminate\\Foundation\\Console',
    'name' => 'Illuminate\\Foundation\\Console\\DownCommand',
    'shortName' => 'DownCommand',
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
            'code' => '\'down\'',
            'attributes' => 
            array (
              'startLine' => 17,
              'endLine' => 17,
              'startTokenPos' => 72,
              'startFilePos' => 554,
              'endTokenPos' => 72,
              'endFilePos' => 559,
            ),
          ),
        ),
      ),
    ),
    'startLine' => 17,
    'endLine' => 184,
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
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'name' => 'signature',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '\'down {--redirect= : The path that users should be redirected to}
                                 {--render= : The view that should be prerendered for display during maintenance mode}
                                 {--retry= : The number of seconds or the datetime after which the request may be retried}
                                 {--refresh= : The number of seconds after which the browser may refresh}
                                 {--secret= : The secret phrase that may be used to bypass maintenance mode}
                                 {--with-secret : Generate a random secret phrase that may be used to bypass maintenance mode}
                                 {--status=503 : The status code that should be used when returning the maintenance mode response}\'',
          'attributes' => 
          array (
            'startLine' => 25,
            'endLine' => 31,
            'startTokenPos' => 94,
            'startFilePos' => 706,
            'endTokenPos' => 94,
            'endFilePos' => 1486,
          ),
        ),
        'docComment' => '/**
 * The console command signature.
 *
 * @var string
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 25,
        'endLine' => 31,
        'startColumn' => 5,
        'endColumn' => 132,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'description' => 
      array (
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'name' => 'description',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '\'Put the application into maintenance / demo mode\'',
          'attributes' => 
          array (
            'startLine' => 38,
            'endLine' => 38,
            'startTokenPos' => 105,
            'startFilePos' => 1601,
            'endTokenPos' => 105,
            'endFilePos' => 1650,
          ),
        ),
        'docComment' => '/**
 * The console command description.
 *
 * @var string
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 38,
        'endLine' => 38,
        'startColumn' => 5,
        'endColumn' => 80,
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
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Execute the console command.
 *
 * @return int
 */',
        'startLine' => 45,
        'endLine' => 79,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'aliasName' => NULL,
      ),
      'getDownFilePayload' => 
      array (
        'name' => 'getDownFilePayload',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the payload to be placed in the "down" file.
 *
 * @return array
 */',
        'startLine' => 86,
        'endLine' => 97,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'aliasName' => NULL,
      ),
      'excludedPaths' => 
      array (
        'name' => 'excludedPaths',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the paths that should be excluded from maintenance mode.
 *
 * @return array
 */',
        'startLine' => 104,
        'endLine' => 115,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'aliasName' => NULL,
      ),
      'redirectPath' => 
      array (
        'name' => 'redirectPath',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the path that users should be redirected to.
 *
 * @return string
 */',
        'startLine' => 122,
        'endLine' => 129,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'aliasName' => NULL,
      ),
      'prerenderView' => 
      array (
        'name' => 'prerenderView',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Prerender the specified view so that it can be rendered even before loading Composer.
 *
 * @return string
 */',
        'startLine' => 136,
        'endLine' => 143,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'aliasName' => NULL,
      ),
      'getRetryTime' => 
      array (
        'name' => 'getRetryTime',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the number of seconds or date / time the client should wait before retrying their request.
 *
 * @return int|string|null
 */',
        'startLine' => 150,
        'endLine' => 169,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'aliasName' => NULL,
      ),
      'getSecret' => 
      array (
        'name' => 'getSecret',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get the secret phrase that may be used to bypass maintenance mode.
 *
 * @return string|null
 */',
        'startLine' => 176,
        'endLine' => 183,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\DownCommand',
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