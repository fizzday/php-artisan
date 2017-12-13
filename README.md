# php-artisan
小巧强悍,可配置的自动化创建文件 artisan 命令工具
## 安装
使用composer
```sh
composer require fizzday/php-artisan dev-master
```
## 配置
```php
$config = array(
    // 允许的操作
    'allow_type' => array(
        'm', // model
        'c', // controller
        's', // service
//        'v', // view
    ),

    // 文件后缀
    'ext' => '.class.php',

    // 自动生成类方法, 生成多个方法, 则添加方法名到数组中
    'auto_method' => [
        'index',
        'test'
    ],

    // 对应模块配置
    'm' => [
        'dir' => __DIR__ . '/Application/Model/', // 文件目录
        'ext' => '.class.php',    // 文件后缀
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
        'ext' => '.class.php',
        // 头部引入等操作
        'head' => [
            "namespace Sapi\\Controller;"
        ],
        // 是否继承, 有值则继承该值, 没有则不继承
        'extends' => 'BaseController',
    ],
    's' => [
        // 文件目录
        'dir' => __DIR__ . '/Application/Service',
        // 文件后缀
        'ext' => '.class.php',
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

return $config;
```
### 配置说明
- 可配置文件后缀, 不仅限于php文件
- 可配置文件创建者共用信息
- 可配置创建文件的目录
- 可配置创建文件的头部引用信息
- 可配置继承关系
- 可配置自动类中的多个方法
> 详情可查看配置文件的注释说明, 一目了然  

## 用法示例
### 创建命令文件`artisan`
```php
<?php

use Fizzday\Artisan\Migration;

echo 'starting...' . PHP_EOL;

// 创建文件
echo Migration::config($config)->run($argv);
```
### 执行命令
```
php artisan make:m FizzModel
```
说明(1):   
- `php artisan make:m` : 创建model文件
- `php artisan make:c` : 创建controller文件
- `php artisan make:s` : 创建service文件  
说明(2):  
- `FizzModel` : 要创建的文件名字
### 执行结果
```
starting...
FizzModel.class.php created successfully
```
### 查看文件`FizzModel.php`
```
<?php
/**
 * Created by artisan command(composer:fizzday/artisan)
 * User: fizzday<fizzday@yeah.net>
 * Home: http://fizzday.net
 * Date: 2017-12-07
 * Time: 13:23:50
 */

namespace Model;

use Think\Model;

class FizzModel extends Model
{
    public function index()
    {
        // TODO
    }

    public function test()
    {
        // TODO
    }
}
```

## todo 