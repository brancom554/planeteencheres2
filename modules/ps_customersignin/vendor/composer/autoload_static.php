<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2e45f43ac3e57e8ef7a9d77f1eff3d96
{
    public static $classMap = array (
        'Ps_CustomerSignIn' => __DIR__ . '/../..' . '/ps_customersignin.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit2e45f43ac3e57e8ef7a9d77f1eff3d96::$classMap;

        }, null, ClassLoader::class);
    }
}
