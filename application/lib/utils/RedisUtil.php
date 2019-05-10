<?php

namespace app\lib\utils;

use think\facade\Config;

//class RedisUtil
//{
//    // HTTP 状态码
//    protected $host = '';
//
//    protected   $port = 6379;
//    //错误具体信息
//    protected  $timeout = '2.5';
//    //自定义的错误码
//    protected  $password = '';
//
//    public $redis = '';
//
//    public function __construct($params = [])
//    {
//
//
//        $this->host = Config::get('redis.redis_host');
//        $this->port = Config::get('redis.redis_port');
//        $this->password  = Config::get('redis.redis_password');
//        $this->timeout  = Config::get('redis.redis_timeout');
//
//        $this->redis = new \Redis();
//        $this->redis->connect($this->host, $this->port, $this->timeout); // 2.5 sec timeout.
//        $this->redis->auth($this->password);
//
////        return $this->redis;
//
//    }
//
//    public  function instance()
//    {
//        $this->redis = new \Redis();
//        $this->redis->connect($this->host, $this->port, $this->timeout); // 2.5 sec timeout.
//        $this->redis->auth($this->password);
//
//        return $this->redis;
//    }
//}










/**
 * Class RedisConnManager
 *
 * 单例模式对redis实例的操作的进一步封装
 * 主要目的：防止过多的连接，一个页面只能存在一个声明连接
 *
 * @author ：
 */
class RedisUtil
{
    private static $redisInstance;
    /**
     * 私有化构造函数
     * 原因：防止外界调用构造新的对象
     */
    private function __construct(){}
    /**
     * 获取redis连接的唯一出口
     */
    static public function getRedisConn(){
        if(!self::$redisInstance instanceof self){
            self::$redisInstance = new self;
        }
        // 获取当前单例
        $temp = self::$redisInstance;
        // 调用私有化方法
        return $temp->connRedis();
    }
    /**
     * 连接ocean 上的redis的私有化方法
     * @return Redis
     */
    static private function connRedis()
    {
        try {
            $redis_ocean = new \Redis();
            $redis_ocean->connect(Config::get('redis.redis_host'), Config::get('redis.redis_port'),Config::get('redis.redis_timeout') );
            $redis_ocean->auth(Config::get('redis.redis_password'));
        }catch (Exception $e){
            echo $e->getMessage().'<br/>';
        }
        return $redis_ocean;
    }
}