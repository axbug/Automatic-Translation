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

class DirEnum
{
    public static function getInputDir(): string
    {
        $runtimePath = app()->getRuntimePath();
        return $runtimePath . '\input\\';
    }

    public static function getOutputDir(): string
    {
        $runtimePath = app()->getRuntimePath();
        return $runtimePath . '\output\\';
    }
}