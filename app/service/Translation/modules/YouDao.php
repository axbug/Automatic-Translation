<?php
/**
 *
 * User: 阿轩.
 * Blog：blog.yxbug.cn
 * Date: 2023/7/1
 * Email: admin@yxbug.cn
 * Description: 有道翻译
 **/

namespace app\service\Translation\modules;

use app\helper\Request;
use think\helper\Str;

class YouDao implements ModuleInterface
{
    private string $api = 'https://openapi.youdao.com/api';
    private string $appkey = '';
    private string $appsecret = '';

    public function __construct()
    {
        $appkey = env('YOUDAO_APPKEY');
        $appsecret = env('YOUDAO_APPSECRET');
        if(empty($appkey)){
            throw new \Exception('请先配置有道云appkey！');
        }
        if(empty($appsecret)){
            throw new \Exception('请先配置有道云appsecret！');
        }
        $this->appkey = $appkey;
        $this->appsecret = $appsecret;
    }

    public function translate(string $text, string $to = 'zh',string $from = 'auto'){
        $params = [
            'q' => $text,
            'from' => $from,
            'to' => $to
        ];
        $params = $this->add_auth_params($params, $this->appkey, $this->appsecret);


        $result = Request::post($this->api, $params);
        $result =  json_decode($result, true);

        return $result['translation'][0] ?? '';
    }

    private function add_auth_params($param, $appKey, $appSecret)
    {
        $q = $param['q'];
        $salt = Str::random(16);
        $curtime = strtotime("now");
        $sign = $this->calculate_sign($appKey, $appSecret, $q, $salt, $curtime);
        $param['appKey'] = $appKey;
        $param['salt'] = $salt;
        $param["curtime"] = $curtime;
        $param['signType'] = 'v3';
        $param['sign'] = $sign;
        return $param;
    }

    private function calculate_sign($appKey, $appSecret, $q, $salt, $curtime): string
    {
        $strSrc = $appKey . $this->get_input($q) . $salt . $curtime . $appSecret;
        return hash("sha256", $strSrc);
    }

    private function get_input($q)
    {
        if (empty($q)) {
            return null;
        }
        $len = mb_strlen($q, 'utf-8');
        return $len <= 20 ? $q : (mb_substr($q, 0, 10) . $len . mb_substr($q, $len - 10, $len));
    }
}