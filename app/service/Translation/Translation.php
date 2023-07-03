<?php
/**
 *
 * User: 阿轩.
 * Blog：blog.yxbug.cn
 * Date: 2023/7/1
 * Email: admin@yxbug.cn
 * Description:
 **/

namespace app\service\Translation;

use app\enum\FormatEnum;
use Symfony\Component\Yaml\Yaml;

class Translation
{
    private $client;

    /**
     * 执行翻译
     * @param string $class 翻译模块类
     * @param array $data 欲翻译数据
     * @param string $format 格式化方式
     * @param string $kv 参考对象
     * @param string $from 当前语言
     * @param string $to 目标语言
     * @param int $delay 延迟时间
     * @return void
     */
    public function run(string $class, array $data, string $format = 'json', string $kv = 'v', string $from = 'auto', string $to = 'en', int $delay = 800000): void
    {
        $this->client = new $class();

        echo PHP_EOL . '正在执行翻译，请稍候......' . PHP_EOL . PHP_EOL;

        $lang = $this->translate($data, $kv, $from, $to, $delay);
        echo PHP_EOL .'翻译完成，正在序列化文件......' . PHP_EOL;
        $result = $this->formatData($lang, $format);
        echo '序列化完成，正在保存文件......' . PHP_EOL;

        $output_path = app()->getRuntimePath() . '/output/' . time() . '_' . $to . '.' . $format;
        $file = fopen($output_path, 'w');
        fwrite($file, mb_convert_encoding($result, 'UTF-8', mb_detect_encoding($result)));
        fclose($file);
        echo '文件保存成功：' . $output_path . PHP_EOL . PHP_EOL;
    }

    /**
     * 递归翻译
     * @param array $data 欲翻译数据
     * @param string $kv 参考对象
     * @param string $from 当前语言
     * @param string $to 目标语言
     * @param int $delay 延迟时间
     * @return array
     */
    private function translate(array $data, string $kv, string $from, string $to, int $delay): array
    {
        $res = [];
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $res[$k] = $this->translate($v, $kv, $from, $to, $delay);
            } else {
                echo "正在翻译  {$$kv}=>";
                $start_time  = microtime(true);
                for ($i = 1; $i < 20; $i++) {
                    $res[$k] = $this->client->translate($$kv, $to, $from);
                    usleep($delay);
                    if ($res[$k]) {
                        break;
                    }
                    echo '.';
                }
                $use_time = round(microtime(true) - $start_time, 2);
                echo ($res[$k] ?? "翻译失败");
                echo "   【耗时：{$use_time}秒,请求次数：{$i} 】" . PHP_EOL;
            }
        }
        return $res;
    }

    /**
     * 格式化数据
     * @param array $list 数据
     * @param string $format 格式化方式
     * @return string 格式化后的数据
     */
    private function formatData(array $list,string $format): string
    {
        switch ($format) {
            case FormatEnum::FORMAT_JSON:
                return json_encode($list, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                break;
            case FormatEnum::FORMAT_PHP:
                return "<?php" . PHP_EOL .  "return " . var_export($list, true) . ';';
                break;
            case FormatEnum::FORMAT_JS:
                $json = json_encode($list, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                return preg_replace('/(")(\w+)(\"):/m', '$2:', $json);
                break;
            case FormatEnum::FORMAT_YAML:
                return Yaml::dump($list);
                break;
        }
        return '';
    }
}