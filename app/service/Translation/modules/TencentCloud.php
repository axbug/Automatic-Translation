<?php
/**
 *
 * User: 阿轩.
 * Blog：blog.yxbug.cn
 * Date: 2023/7/1
 * Email: admin@yxbug.cn
 * Description: 腾讯云翻译
 **/

namespace app\service\Translation\modules;

use TencentCloud\Common\CommonClient;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;

class TencentCloud implements ModuleInterface
{
    private string $secret_id = '';
    private string $secred_key= '';

    public function __construct()
    {
        $secret_id = env('TENCENT_SECRETID');
        $secred_key = env('TENCENT_SECREDKEY');
        if(empty($secret_id)){
            throw new \Exception('请先配置腾讯云appid！');
        }
        if(empty($secred_key)){
            throw new \Exception('请先配置腾讯云key！');
        }
        $this->secret_id = $secret_id;
        $this->secred_key = $secred_key;
    }

    public function translate(string $text, string $to = 'zh',string $from = 'auto'){
        $cred = new Credential($this->secret_id, $this->secred_key);
        $httpProfile = new HttpProfile();
        $httpProfile->setEndpoint("tmt.tencentcloudapi.com");
        $clientProfile = new ClientProfile();
        $clientProfile->setHttpProfile($httpProfile);
        $client = new CommonClient("tmt", "2018-03-21", $cred, "ap-guangzhou", $clientProfile);
        $resp = $client->callJson("TextTranslate", (object)[
            'SourceText' => $text,
            'Source' => $from,
            'Target' => $to,
            'ProjectId' => 0,
        ]);

        return $resp['TargetText'] ?? '';
    }
}