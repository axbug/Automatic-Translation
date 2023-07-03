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

class FormatEnum
{
    const FORMAT_JS = 'js';
    const FORMAT_JSON = 'json';
    const FORMAT_PHP = 'php';
    const FORMAT_YAML = 'yaml';

    const FORMAT_MAP = [self::FORMAT_JS,self::FORMAT_JSON, self::FORMAT_PHP, self::FORMAT_YAML];

    public static function getEnum(int $index): string
    {
        return self::FORMAT_MAP[$index];
    }
}