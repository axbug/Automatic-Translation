<?php
/**
 *
 * User: 阿轩.
 * Blog：blog.yxbug.cn
 * Date: 2023/7/1
 * Email: admin@yxbug.cn
 * Description: 百度翻译
 **/

namespace app\service\Translation\modules;

use app\helper\Request;
use think\helper\Str;

class Baidu implements ModuleInterface
{
    private string $api = 'https://fanyi-api.baidu.com/api/trans/vip/translate';
    private string $appid = '';
    private string $key = '';

    public function __construct()
    {
        $appid = env('BAIDU_APPID');
        $key = env('BAIDU_KEY');
        if(empty($appid)){
            throw new \Exception('请先配置百度云appid！');
        }
        if(empty($key)){
            throw new \Exception('请先配置百度云key！');
        }
        $this->appid = $appid;
        $this->key = $key;

    }

    public function translate(string $text,string $to = 'zh',string $from = 'auto'){
        $salt = Str::random(8);

        $data = [
            'q' => $text,
            'from' => $from,
            'to' => $to,
            'appid' => $this->appid,
            'salt' => $salt,
            'sign' => md5($this->appid . $text . $salt . $this->key),
        ];

        $result = Request::post($this->api,$data);
        $result = json_decode($result,true);

        return $result['trans_result'][0]['dst'] ?? '';
    }

}