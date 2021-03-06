<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit84651c138dec41305ecc9bbf4bb1c63d
{
    public static $files = array (
        'fe17454461a24db888b8da8720edd309' => __DIR__ . '/..' . '/athlon1600/php-proxy/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\EventDispatcher\\' => 34,
        ),
        'P' => 
        array (
            'Proxy\\' => 6,
            'Phasty\\Log\\' => 11,
        ),
        'J' => 
        array (
            'Jaybizzle\\CrawlerDetect\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'Proxy\\' => 
        array (
            0 => __DIR__ . '/..' . '/athlon1600/php-proxy/src',
        ),
        'Phasty\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/phasty/log/src',
        ),
        'Jaybizzle\\CrawlerDetect\\' => 
        array (
            0 => __DIR__ . '/..' . '/jaybizzle/crawler-detect/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit84651c138dec41305ecc9bbf4bb1c63d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit84651c138dec41305ecc9bbf4bb1c63d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
