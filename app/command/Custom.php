<?php
declare (strict_types = 1);

namespace app\command;

use app\service\Translation\modules\Baidu;
use app\service\Translation\Translation;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Custom extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('custom')
            ->setDescription('自定义执行翻译脚本');
    }

    protected function execute(Input $input, Output $output)
    {
        $client = new Translation();

//        $json = '';
//        $data = json_decode($json,true);

        $data = [

        ];

        $client->run(Baidu::class , $data,'json','v','auto','en');
    }
}
