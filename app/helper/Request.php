<?php
/**
 *
 * User: 阿轩.
 * Blog：blog.yxbug.cn
 * Date: 2022/10/12
 * Email: admin@yxbug.cn
 * Description: HTTP网络请求类
 **/

namespace app\helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Request
{
    /**
     * 发起HTTP请求
     * @param string $url 请求URL链接
     * @param string $methods 请求方式：POST/GET
     * @param array $data 请求数据
     * @param array $header 请求头
     * @param bool $origin 是否返回原始数据
     * @return string 响应数据
     * @throws GuzzleException
     */
    public static function request(string $url = "", string $methods = "GET", array $data = [], array $header = [], bool $origin = false): string
    {
        $client = new Client();
        $response = $client->request($methods, $url, [
            'query' => $data,
            'headers' => $header,
            'verify' => false,
        ]);
        if ($origin) return $origin;
        return (string)$response->getBody();
    }

    /**
     * 发起HTTP Get请求
     * @param string $url 请求URL地址
     * @param array $data 请求数据
     * @param array $header 请求头
     * @param bool $origin 是否返回原始数据
     * @return string 响应数据
     * @throws GuzzleException
     */
    public static function get(string $url = "", array $data = [], array $header = [
        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36',
    ], bool $origin = false): string
    {
        return self::request($url, "GET", $data, $header, $origin);
    }

    /**
     * 发起HTTP POST请求
     * @param string $url 请求URL地址
     * @param array $data 请求数据
     * @param array $header 请求头
     * @param bool $origin 是否返回原始数据
     * @return string 响应数据
     * @throws GuzzleException
     */
    public static function post(string $url = "", array $data = [], array $header = [
        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36',
    ], bool $origin = false): string
    {
        return self::request($url, "POST", $data, $header, $origin);
    }
}