<?php
declare (strict_types = 1);

namespace app\command;

use app\enum\DirEnum;
use app\enum\ModulesEnum;
use app\enum\FormatEnum;
use app\helper\Tools;
use app\service\Translation\Translation;
use Symfony\Component\Yaml\Yaml;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Guide extends Command
{
    private string $module = '';
    private string $refer = '';
    private string $format = '';
    private array $language = [];
    private array $data = [];

    protected function configure(): void
    {
        $this->setName('guide')->setDescription('引导执行翻译脚本');
    }

    protected function execute(Input $input, Output $output): void
    {
        $this->chooseFile();
        $this->chooseRefer();
        $this->chooseFormat();
        $this->chooseModule();
        $this->chooseLanguage();
        $this->onStart();
    }

    /**
     * 选择需要翻译的文件
     * @return void
     */
    private function chooseFile(): void
    {;
        $lock = true;
        $input_path = DirEnum::getInputDir();

        $files = [];
        while ($lock){
            $files = [];
            $_files = scandir($input_path);
            foreach ($_files as $file){
                if(($file !== '.' && $file !== '..')){
                    $extension_name = Tools::getExtensionName($file);
                    if(in_array($extension_name,['php','json','yml','yaml'])){
                        $files[] = $file;
                    }
                }
            }

            if(empty($files)){
                $this->output->writeln('请先将需翻译的 PHP/JSON/YAML/YML 文件放置在 runtime/input 目录下！' . PHP_EOL);
                $this->output->write('是否重新扫描目录？(y/n)');
                $code = strtolower(readline());
                $code !== 'y' && exit;
            }else{
                $lock = false;
            }
        }

        $this->getLanguage($files);
    }

    /**
     * 选择文件并获取原始语言包
     * @param array $files 路径列表
     * @return void
     */
    private function getLanguage(array $files): void
    {
        $lock = true;
        while ($lock){
            $this->output->writeln("请选择需要翻译的文件");
            foreach ($files as $index => $file) {
                $this->output->writeln($index . ' => ' .$file);
            }

            $this->output->write(PHP_EOL . "请输入文件索引：");
            $index = intval(readline());

            if(empty($files[$index])){
                $this->output->writeln('请输入正确的文件索引！' . PHP_EOL);
                $this->chooseFile();
                return;
            }else{
                $lock = false;
            }
            $file_path = $files[$index];
        }


        $extension_name = Tools::getExtensionName($file_path);
        $input_path = DirEnum::getInputDir();
        $file_content = file_get_contents($input_path . $file_path);

        $input_data = [];
        try{
            if($extension_name === 'php'){
                $input_data = include $input_path . $file_path;
            }elseif($extension_name === 'json'){
                $input_data = json_decode($file_content,true);
            }elseif(in_array($extension_name,['yml','yaml'])){
                $input_data = Yaml::parse($file_content);
            }
        }catch (\Exception $e){}

        if(empty($input_data) || !is_array($input_data)){
            $this->output->writeln('请输入正确的文件！' . PHP_EOL);
            $this->chooseFile();
            return;
        }

        $this->output->writeln('已选择选择文件：' . $file_path);

        $this->data = $input_data;
    }

    /**
     * 选择翻译参考对象
     * @return void
     */
    private function chooseRefer(): void
    {
        $lock = true;
        while ($lock){
            $this->output->write(PHP_EOL . "请选择翻译参照属性【键名/键值】（k/v）：");
            $code = strtolower(readline());
            if(in_array($code,['k','v'])){
                $this->refer = $code;
                $this->output->writeln('当前翻译参照属性：'. ($this->refer === 'k' ? '键名' : '键值') . PHP_EOL);
                $lock = false;
            }
        }

    }

    /**
     * 选择输出文件格式化方式
     * @return void
     */
    private function chooseFormat(): void
    {
        $lock = true;
        $map = FormatEnum::FORMAT_MAP;
        while ($lock){
            $this->output->writeln("请选择输出文件格式化方式");
            foreach ($map as $index => $type){
                $this->output->writeln($index . ' => ' .$type);
            }

            $this->output->write(PHP_EOL . "请输入格式化方式索引：");
            $index = intval(readline());

            if(!empty($map[$index])){
                $this->format = $map[$index];
                $lock = false;
            }else{
                $this->output->writeln('请输入正确的格式化方式索引！' . PHP_EOL);
            }
        }

        $this->output->writeln('输出文件格式化方式：' . $this->format . PHP_EOL);
    }

    /**
     * 选择翻译模块
     * @return void
     */
    private function chooseModule(): void
    {
        $translation_mode_map = ModulesEnum::MODULES_MAP;

        $lock = true;
        while ($lock){
            $this->output->writeln('请选择翻译模块：');
            foreach ($translation_mode_map as $index => $item){
                $this->output->writeln($index . ' => ' . $item['title']);
            }

            $this->output->write(PHP_EOL . "请输入翻译模块索引：");
            $index = intval(readline());
            if(empty($translation_mode_map[$index])){
                $this->output->writeln('请输入正确的翻译模块索引！' . PHP_EOL);
            }else{
                $lock = false;
            }
        }

        $option = $translation_mode_map[$index];
        $this->output->writeln('当前翻译模块：' . $option['title']);
        $this->output->writeln('相关文档地址：' . $option['doc'] . PHP_EOL);
        $this->module = $option['class'];
    }

    /**
     * 选择当前语言和目标语言
     * @return void
     */
    private function chooseLanguage(): void
    {

        $this->output->write(PHP_EOL . "请输入当前语言代码（auto）：");
        $lang = readline();
        if(!empty($lang)){
            $this->language[0] = $lang;
        }else{
            $this->language[0] = 'auto';
        }

        $lock = true;
        while ($lock){
            $this->output->write(PHP_EOL . "请输入翻译语言代码：");
            $lang = readline();
            if(!empty($lang)){
                $this->language[1] = $lang;
                $lock = false;
            }
        }

        $this->output->write(PHP_EOL . "当前翻译方式：" . $this->language[0] . ' => ' . $this->language[1] . ' 是否继续(y/n)：');
        $code = strtolower(readline());
        if($code !== 'y'){
            $this->chooseLanguage();
            return;
        }
    }

    /**
     * 准备执行翻译命令
     * @return void
     */
    private function onStart(): void{
        $this->output->writeln(PHP_EOL . '即将执行翻译，请检查信息是否有误......' . PHP_EOL);
        sleep(1);

        $this->output->writeln('当前翻译模块：' . $this->module);
        $this->output->writeln('当前翻译方式：' . $this->language[0] . ' => ' . $this->language[1]);
        $this->output->writeln('当前翻译参照：' . ($this->refer === 'k' ? '键名' : '键值'));
        $this->output->writeln('当前输出文件：' . $this->format . PHP_EOL);

        $this->output->write(PHP_EOL . '是否执行翻译(y/n)：');
        $code = strtolower(readline());
        if($code === 'y'){
            $client = new Translation();
            $client->run($this->module, $this->data, $this->format, $this->refer, $this->language[0], $this->language[1]);
        }
    }
}
