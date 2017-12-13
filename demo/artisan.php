<?php
require '../src/Migration.php';

use Fizzday\Artisan\Migration;

$config = array(
    // 允许的操作
    'allow_type' => array(
        'm', // model
        'c', // controller
        's', // service
//        'v', // view
    ),

    // 文件后缀
    'ext' => '.php',

    // 自动生成类方法, 生成多个方法, 则添加方法名到数组中
    'auto_methods' => [
//        'index',
//        'test'
    ],

    // 对应模块配置
    'm' => [
        'dir' => __DIR__ . '/Application/Model/', // 文件目录
        'ext' => '.php',    // 文件后缀
        'head' => [   // 头部引入等操作
            "namespace Model;" . PHP_EOL,
            "use Think\\Model;",
        ],
        // 是否继承, 有值则继承该值, 没有则不继承
        'extends' => 'Model',
    ],
    'c' => [
        // 文件目录
        'dir' => __DIR__ . '/Application/Sapi/Controller/',
        // 文件后缀
        'ext' => 'Controller.php',
        // 头部引入等操作
        'head' => [
            "namespace Sapi\\Controller;"
        ],
        // 是否继承, 有值则继承该值, 没有则不继承
        'extends' => 'BaseController',
        // 自动生成类方法, 生成多个方法, 则添加方法名到数组中
        'auto_methods' => [
            'index',
            'test'
        ],
    ],
    's' => [
        // 文件目录
        'dir' => __DIR__ . '/Application/Service',
        // 文件后缀
        'ext' => 'Service.php',
        // 头部引入等操作
        'head' => [
            "namespace Service;"
        ],
        // 是否继承, 有值则继承该值, 没有则不继承
        'extends' => 'BaseService',
    ],

    // 公共头部文件信息
    'file_info' => [
        '/**',
        ' * Created by artisan command(composer:fizzday/artisan)',
        ' * User: fizzday<fizzday@yeah.net>',
        ' * Home: http://fizzday.net',
        ' * Date: ' . date("Y-m-d"),
        ' * Time: ' . date("H:i:s"),
        ' */'
    ],
);

echo 'starting...' . PHP_EOL;

// 创建文件
echo Migration::config($config)->run($argv);

// 最后执行

// php artisan.php make:c Test

