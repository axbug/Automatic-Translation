<?php
declare (strict_types = 1);

namespace app;

use app\enum\DirEnum;
use think\Service;

/**
 * 应用服务类
 */
class AppService extends Service
{
    public function register()
    {
        // 服务注册

        $runtimePath = app()->getRuntimePath();
        $input_path = DirEnum::getInputDir();
        $output_path = DirEnum::getOutputDir();
        $path_list = [
            $runtimePath, $input_path, $output_path
        ];

        foreach ($path_list as $path){
            if(!is_readable($path)){
                is_file($path) || mkdir($path);
            }
        }
    }

    public function boot()
    {
        // 服务启动
    }
}
