<?php
/**
 *
 * User: 阿轩.
 * Blog：blog.yxbug.cn
 * Date: 2023/7/1
 * Email: admin@yxbug.cn
 * Description: 阿里云翻译
 **/

namespace app\service\Translation\modules;

use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use Darabonba\OpenApi\Models\Config;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Darabonba\OpenApi\Models\Params;
use Darabonba\OpenApi\OpenApiClient;

class AliCloud implements ModuleInterface
{
    private OpenApiClient $client;


    public function __construct()
    {
        $access_id = env('ALIYUN_ACCESS_ID');
        $access_secret = env('ALIYUN_ACCESS_SECRET');
        if(empty($access_id)){
            throw new \Exception('请先配置阿里云access id！');
        }
        if(empty($access_secret)){
            throw new \Exception('请先配置阿里云access secret！');
        }

        $config = new Config([
            "accessKeyId" => $access_id,
            "accessKeySecret" => $access_secret
        ]);

        $config->endpoint = "mt.cn-hangzhou.aliyuncs.com";
        $this->client = new OpenApiClient($config);
    }

    public function translate(string $text,string $to = 'zh',string $from = 'auto'){
        $params = self::createApiInfo();
        $body = [];
        $body["FormatType"] = 'text';
        $body["SourceLanguage"] = $from;
        $body["TargetLanguage"] = $to;
        $body["SourceText"] = $text;
        $body["Scene"] = 'general';
        $runtime = new RuntimeOptions([]);
        $request = new OpenApiRequest([
            "body" => $body
        ]);
        $result = $this->client->callApi($params, $request, $runtime);

        return $result['body']['Data']['Translated'] ?? '';
    }

    public static function createApiInfo(): Params
    {
        return new Params([
            "action" => "TranslateGeneral",
            "version" => "2018-10-12",
            "protocol" => "HTTPS",
            "method" => "POST",
            "authType" => "AK",
            "style" => "RPC",
            "pathname" => "/",
            "reqBodyType" => "formData",
            "bodyType" => "json"
        ]);
    }
}