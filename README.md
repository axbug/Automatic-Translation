<h3 align="center" style="margin: 30px 0 30px;font-weight: bold;font-size:40px;">多语言翻译与国际化（i18n）脚本工具</h3>

[![star](https://gitee.com/yxbug/Automatic-Translation/badge/star.svg?theme=dark)](https://gitee.com/yxbug/Automatic-Translation/stargazers)
[![fork](https://gitee.com/yxbug/Automatic-Translation/badge/fork.svg?theme=dark)](https://gitee.com/yxbug/Automatic-Translation/members)
[![stars](https://img.shields.io/github/stars/axbug/Automatic-Translation?style=flat-square&logo=GitHub)](https://github.com/axbug/Automatic-Translation)
[![forks](https://img.shields.io/github/forks/axbug/Automatic-Translation?style=flat-square&logo=GitHub)](https://github.com/axbug/Automatic-Translation)
[![issues](https://img.shields.io/github/issues/axbug/Automatic-Translation?style=flat-square&logo=GitHub)](https://github.com/axbug/Automatic-Translation/issues)
[![Website](https://img.shields.io/badge/site-blog.yxbug.cn-blue?style=flat-square)](https://blog.yxbug.cn)
[![release](https://img.shields.io/github/v/release/axbug/Automatic-Translation?style=flat-square)](https://gitee.com/axbug/Automatic-Translation/releases)
[![license](https://img.shields.io/github/license/axbug/Automatic-Translation?style=flat-square)](https://en.wikipedia.org/wiki/MIT_License)

## 项目概览
本项目是一款面向全球化开发的多语言翻译和国际化(i18n)处理工具，基于 **PHP8** 和 **ThinkPHP8** 开发。它专注于简化多语言内容批量翻译和格式化输出的过程，以满足不同项目的国际化需求。

## 核心功能特性
 - **全面支持国际化（i18n）流程**：无论是初次接触PHP的新手还是经验丰富的开发者，均可通过引导模式或自定义模式轻松进行多语言内容管理。
 - **双工作模式**：
   - 引导模式：为未接触PHP或i18n初学者提供直观易懂的步骤指导，实现无障碍翻译和导入。
   - 自定义模式：为有PHP基础的同学提供定制和灵活操作，适应复杂多样的国际化配置需求。
 - 高效批量翻译与导出能力：不仅支持批量导入和翻译，并可将已翻译好的数据一键格式化输出为多种常见格式，如PHP数组、JSON对象、YAML文档以及JavaScript对象，确保无缝集成到各种前后端项目中。

## 安装与使用
### 安装依赖
```shell
composer install
```

### 引导模式
```shell
php think guide
```

### 自定义模式
```shell
php think custom
```

## 输出格式与兼容性
本工具着重于实现跨平台和跨技术栈的兼容性，支持以下多语言文件格式：
 - PHP语言变量文件（.php)
 - JSON语言包（.json)
 - YAML语言配置文件（.yaml/.yml)
 - JavaScript语言模块（.js）

## 参考来源
非常感谢各位前辈的开源项目，对本项目参考的来源表示由衷的感谢！！！

| 拓展库      | 链接                                |
|----------|-----------------------------------|
| thinkphp | 	https://www.thinkphp.cn/         |
| guzzle   | 	https://github.com/guzzle/guzzle |
| symfony  | 	https://symfony.com/sponsor      |
| …        | 	致敬各位大佬                           |

## 赞助项目
如果您觉得本项目对您有所帮助，请适当的赞助，我将持续更新项目以回报您的支持，赞助请备注大名，感谢您的赞助与支持！

<div style="display: flex;width:100%;text-align: center">
    <div style="width:30%;">
        <div><span style="font-weight: 800;line-height: 3rem;font-size: 1rem;">微信</span></div>
        <div><img src="https://gz.api.app.yxbug.cn/link/image/wechat_pay"  alt="微信赞助"/></div>
    </div>
    <div style="width:30%;">
        <div><span style="font-weight: 800;line-height: 3rem;font-size: 1rem;">支付宝</span></div>
        <div><img src="https://gz.api.app.yxbug.cn/link/image/alipay"  alt="支付宝赞助" /></div>
    </div>
    <div style="width:30%;">
        <div><span style="font-weight: 800;line-height: 3rem;font-size: 1rem;">QQ</span></div>
        <div><img src="https://gz.api.app.yxbug.cn/link/image/qq_pay"  alt="QQ赞助" /></div>
    </div>
</div>

## 关于项目
作者博客：[https://blog.yxbug.cn/](https://blog.yxbug.cn/)

前端实验室：[https://lab.yxbug.cn/](https://lab.yxbug.cn/)