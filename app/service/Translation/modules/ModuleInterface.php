<?php
/**
 *
 * User: 阿轩.
 * Blog：blog.yxbug.cn
 * Date: 2023/7/1
 * Email: admin@yxbug.cn
 * Description:
 **/

namespace app\service\Translation\modules;

interface ModuleInterface
{
    public function translate(string $text,string $to = 'zh',string $from = 'auto');
}