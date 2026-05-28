<?php declare(strict_types = 1);

// osfsl-/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/framework/src/Illuminate/Foundation/Console/BroadcastingInstallCommand.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Illuminate\Foundation\Console\BroadcastingInstallCommand
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-093c77339f97e27427f312b9c059f562ba123abf4fb706c62e3eea5cc8667956-8.5.6-6.70.0.1',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'filename' => '/Users/silkalns/Fresh Projects/adminlte-laravel/vendor/composer/../laravel/framework/src/Illuminate/Foundation/Console/BroadcastingInstallCommand.php',
      ),
    ),
    'namespace' => 'Illuminate\\Foundation\\Console',
    'name' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
    'shortName' => 'BroadcastingInstallCommand',
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
            'code' => '\'install:broadcasting\'',
            'attributes' => 
            array (
              'startLine' => 19,
              'endLine' => 19,
              'startTokenPos' => 85,
              'startFilePos' => 531,
              'endTokenPos' => 85,
              'endFilePos' => 552,
            ),
          ),
        ),
      ),
    ),
    'startLine' => 19,
    'endLine' => 524,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Console\\Command',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Illuminate\\Foundation\\Console\\InteractsWithComposerPackages',
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'signature' => 
      array (
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'name' => 'signature',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '\'install:broadcasting
                    {--composer=global : Absolute path to the Composer binary which should be used to install packages}
                    {--force : Overwrite any existing broadcasting routes file}
                    {--without-reverb : Do not prompt to install Laravel Reverb}
                    {--reverb : Install Laravel Reverb as the default broadcaster}
                    {--pusher : Install Pusher as the default broadcaster}
                    {--ably : Install Ably as the default broadcaster}
                    {--without-node : Do not prompt to install Node dependencies}\'',
          'attributes' => 
          array (
            'startLine' => 29,
            'endLine' => 36,
            'startTokenPos' => 112,
            'startFilePos' => 770,
            'endTokenPos' => 112,
            'endFilePos' => 1383,
          ),
        ),
        'docComment' => '/**
 * The name and signature of the console command.
 *
 * @var string
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 29,
        'endLine' => 36,
        'startColumn' => 5,
        'endColumn' => 83,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'description' => 
      array (
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'name' => 'description',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '\'Create a broadcasting channel routes file\'',
          'attributes' => 
          array (
            'startLine' => 43,
            'endLine' => 43,
            'startTokenPos' => 123,
            'startFilePos' => 1498,
            'endTokenPos' => 123,
            'endFilePos' => 1540,
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
        'startLine' => 43,
        'endLine' => 43,
        'startColumn' => 5,
        'endColumn' => 73,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'driver' => 
      array (
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'name' => 'driver',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => 'null',
          'attributes' => 
          array (
            'startLine' => 50,
            'endLine' => 50,
            'startTokenPos' => 134,
            'startFilePos' => 1654,
            'endTokenPos' => 134,
            'endFilePos' => 1657,
          ),
        ),
        'docComment' => '/**
 * The broadcasting driver to use.
 *
 * @var string|null
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 50,
        'endLine' => 50,
        'startColumn' => 5,
        'endColumn' => 29,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'frameworkPackages' => 
      array (
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'name' => 'frameworkPackages',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'react\' => \'@laravel/echo-react\', \'vue\' => \'@laravel/echo-vue\']',
          'attributes' => 
          array (
            'startLine' => 57,
            'endLine' => 60,
            'startTokenPos' => 145,
            'startFilePos' => 1779,
            'endTokenPos' => 161,
            'endFilePos' => 1865,
          ),
        ),
        'docComment' => '/**
 * The framework packages to install.
 *
 * @var array
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 57,
        'endLine' => 60,
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
 * @return void
 */',
        'startLine' => 67,
        'endLine' => 137,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'uncommentChannelsRoutesFile' => 
      array (
        'name' => 'uncommentChannelsRoutesFile',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Uncomment the "channels" routes file in the application bootstrap file.
 *
 * @return void
 */',
        'startLine' => 144,
        'endLine' => 173,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'enableBroadcastServiceProvider' => 
      array (
        'name' => 'enableBroadcastServiceProvider',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Uncomment the "BroadcastServiceProvider" in the application configuration.
 *
 * @return void
 */',
        'startLine' => 180,
        'endLine' => 200,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'collectDriverConfig' => 
      array (
        'name' => 'collectDriverConfig',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Collect the driver configuration.
 *
 * @return void
 */',
        'startLine' => 207,
        'endLine' => 220,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'installDriverPackages' => 
      array (
        'name' => 'installDriverPackages',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Install the driver packages.
 *
 * @return void
 */',
        'startLine' => 227,
        'endLine' => 240,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'collectPusherConfig' => 
      array (
        'name' => 'collectPusherConfig',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Collect the Pusher configuration.
 *
 * @return void
 */',
        'startLine' => 247,
        'endLine' => 278,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'collectAblyConfig' => 
      array (
        'name' => 'collectAblyConfig',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Collect the Ably configuration.
 *
 * @return void
 */',
        'startLine' => 285,
        'endLine' => 298,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'injectFrameworkSpecificConfiguration' => 
      array (
        'name' => 'injectFrameworkSpecificConfiguration',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Inject Echo configuration into the application\'s main file.
 *
 * @return void
 */',
        'startLine' => 305,
        'endLine' => 365,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'installReverb' => 
      array (
        'name' => 'installReverb',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Install Laravel Reverb into the application if desired.
 *
 * @return void
 */',
        'startLine' => 372,
        'endLine' => 393,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'installNodeDependencies' => 
      array (
        'name' => 'installNodeDependencies',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Install and build Node dependencies.
 *
 * @return void
 */',
        'startLine' => 400,
        'endLine' => 448,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'resolveDriver' => 
      array (
        'name' => 'resolveDriver',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'string',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Resolve the provider to use based on the user\'s choice.
 *
 * @return string
 */',
        'startLine' => 455,
        'endLine' => 474,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'isUsingSupportedFramework' => 
      array (
        'name' => 'isUsingSupportedFramework',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Detect if the user is using a supported framework (React or Vue).
 *
 * @return bool
 */',
        'startLine' => 481,
        'endLine' => 484,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'appUsesReact' => 
      array (
        'name' => 'appUsesReact',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Detect if the user is using React.
 *
 * @return bool
 */',
        'startLine' => 491,
        'endLine' => 494,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'appUsesVue' => 
      array (
        'name' => 'appUsesVue',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Detect if the user is using Vue.
 *
 * @return bool
 */',
        'startLine' => 501,
        'endLine' => 504,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'aliasName' => NULL,
      ),
      'packageDependenciesInclude' => 
      array (
        'name' => 'packageDependenciesInclude',
        'parameters' => 
        array (
          'package' => 
          array (
            'name' => 'package',
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
            'startLine' => 511,
            'endLine' => 511,
            'startColumn' => 51,
            'endColumn' => 65,
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
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Detect if the package is installed.
 *
 * @return bool
 */',
        'startLine' => 511,
        'endLine' => 523,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 2,
        'namespace' => 'Illuminate\\Foundation\\Console',
        'declaringClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'implementingClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
        'currentClassName' => 'Illuminate\\Foundation\\Console\\BroadcastingInstallCommand',
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