<?php
/**
 * Created by PhpStorm.
 * User: fizz
 * Date: 2017/12/11
 * Time: 18:04
 */

namespace Fizzday\Artisan;

class Migration
{
    /**
     * 配置文件
     * @var array
     */
    protected static $config = array();

    /**
     * 执行操作
     * @param array $param
     */
    public static function run($param = array())
    {
        try {
            // 参数检查, 并提取文件和操作类型
            $check = self::check($param);
            $file = $check['file'];
            $type = $check['type'];

            // 根据类型, 生成内容
            $content = self::fillContent($file, $type);

            // 生成文件
            self::makeFile($file, $type, $content);

            return basename($file) . ' created successfully' . PHP_EOL;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 创建文件
     * @param $file
     * @param string $type 文件类型(m/v/c:模型/视图/控制器)
     */
    private static function check($param = array())
    {
        if (empty($param[1])) throw new \Exception('error!!! oper param can not empty');

        // 接收操作 (make:m, make:v, make:c)
        $opers = $param[1];
        if (!strpos($opers, ':')) throw new \Exception('error!!! oper format error');
        // 获取操作名
        $type = (explode(":", $opers));  // m,v,c,s
        if (!in_array($type[1], self::$config['allow_type'])) throw new \Exception('error!!! oper forbidden');

        // 获取文件
        if (empty($param[2])) throw new \Exception('error!!! file name can not empty');
        $file = $param[2];

        $type = $type[1];
        return array(
            'file' => $file . (self::$config[$type]['ext'] ?: self::$config['ext']),
            'type' => $type
        );
    }

    /**
     * 生成填充内容
     * @param $file
     * @param $type
     * @return string
     */
    private static function fillContent($file, $type)
    {
        $fileName = basename($file);
        if (strpos($fileName, '.')) $fileName = explode('.', $fileName)[0];

        $content = '';
        $content .= '<?php';
        $content .= PHP_EOL;
        // 写入文件信息
        $content .= implode(PHP_EOL, self::$config['file_info']);
        $content .= PHP_EOL;
        $content .= PHP_EOL;
        // 写入头部引用模块信息
        switch ($type) {
            case "aaa": // m , c, s
                break;

            default:
                // 写入头部引用
                $content .= implode(PHP_EOL, self::$config[$type]['head']);
                $content .= PHP_EOL . PHP_EOL;
                // 写入class+类名
                $content .= 'class ' . $fileName;
                $content .= self::$config[$type]['extends'] ? ' extends ' . self::$config[$type]['extends'] : '';
                break;
        }
        $content .= PHP_EOL;
        $content .= '{';
        $content .= PHP_EOL;
        // 生成方法名
        if ($methods = self::$config['auto_methods']) {
            foreach ($methods as $item) {
                $content .= '    public function '.$item.'()';
                $content .= PHP_EOL;
                $content .= '    {';
                $content .= PHP_EOL;
                $content .= '        // TODO';
                $content .= PHP_EOL;
                $content .= '    }';
                $content .= PHP_EOL;
                $content .= PHP_EOL;
            }
        } else {
            $content .= '    // TODO';
        }
        $content .= PHP_EOL;
        $content .= '}';
        $content .= PHP_EOL;

        return $content;
    }

    /**
     * 创建文件
     * @param array $check
     * @return string
     * @throws Exception
     */
    private static function makeFile($file, $type, $content)
    {
        // 获取操作系统类型
        $os_name = PHP_OS;
//        if (strpos($os_name, "Linux") !== false) {
//            $os_str = '*nix';
//        } else
        if (strpos($os_name, "WIN") !== false) {
            $os_str = "win";
        } else {
            $os_str = '*nix';
        }

        $dir_full = rtrim(self::$config[$type]['dir'], '/') . '/';

        if ($os_str == 'win') {
            $dir_real = str_replace('/', '\\', $dir_full);
        } else {
            $dir_real = str_replace('\\', '/', $dir_full);
        }

        $file = $dir_real . $file;
        // 检查是否有写权限
        $dir = dirname($file);
//        $fileName = basename($file);
        if (!is_dir($dir)) throw new \Exception('error!!! dir "' . $dir . '" is not exists');
        if (!is_writable($dir)) throw new \Exception('error!!! ' . $dir . ' is not writable');

        // 检查文件是否存在
        if (file_exists($file)) throw new \Exception("error!!! file already exists.");

        // 写文件
//        try {
        file_put_contents($file, $content);
        chmod($file, 0755);
//        } catch (\Exception $e) {
//            throw new \Exception($e->getMessage());
//        }
    }

    /**
     * 加载配置文件
     * @param array $config
     * @return static
     */
    public static function config($config = array())
    {
        self::$config = $config;

        return new static();
    }
}