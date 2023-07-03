<?php
/**
 *
 * User: 阿轩.
 * Blog：blog.yxbug.cn
 * Date: 2023/7/1
 * Email: admin@yxbug.cn
 * Description:
 **/

namespace app\helper;

class Tools
{
    /**
     * 获取文件拓展名
     * @param string $val
     * @return string
     */
    public static function getExtensionName(string $val): string
    {
        $extension_name = substr($val, strrpos($val, '.')+1);
        return strtolower($extension_name);
    }
}