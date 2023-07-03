<?php
/**
 *
 * User: 阿轩.
 * Blog：blog.yxbug.cn
 * Date: 2023/7/1
 * Email: admin@yxbug.cn
 * Description:
 **/

namespace app\enum;

use app\service\Translation\modules\AliCloud;
use app\service\Translation\modules\Baidu;
use app\service\Translation\modules\TencentCloud;
use app\service\Translation\modules\YouDao;

class ModulesEnum
{
    const BAIDU = [
        'title'=>'百度翻译',
        'class'=>Baidu::class,
        'doc' => 'https://fanyi-api.baidu.com/doc/21',
    ];

    const YOUDAO = [
        'title'=>'有道翻译',
        'class'=>YouDao::class,
        'doc' => 'https://ai.youdao.com/DOCSIRMA/html/trans/api/wbfy/index.html#section-12',
    ];

    const TENCENT = [
        'title'=>'腾讯翻译',
        'class'=>TencentCloud::class,
        'doc' => 'https://cloud.tencent.com/document/product/551/15619',
    ];

    const ALI_CLOUD = [
        'title'=>'阿里翻译',
        'class'=>AliCloud::class,
        'doc' => 'https://help.aliyun.com/zh/machine-translation/support/supported-languages-and-codes',
    ];


    const MODULES_MAP = [
        self::BAIDU,
        self::YOUDAO,
        self::TENCENT,
        self::ALI_CLOUD,
    ];

    public static function getEnum(int $index): array
    {
        return self::MODULES_MAP[$index];
    }
}