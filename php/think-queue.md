###使用think-queue和predis的记录
####以下是composer.json部分配置,此处不介绍predis和think-queue的安装
    "require": {
        "php": ">=5.6.0",
        "topthink/framework": "5.1.*",
        "topthink/think-queue": "v2.0.3",
        "predis/predis": "^1.1"
    },
1.首先选用redis驱动，修改config/queue.php

    'connector'  => 'Redis',         // Redis 驱动
    'expire'     => 60,              // 任务的过期时间，默认为60秒; 若要禁用，则设置为 null
    'default'    => 'default',       // 默认的队列名称
    'host'       => '192.168.99.100',     // redis 主机ip
    'port'       => 6379,            // redis 端口
    'password'   => '',              // redis 密码
    'select'     => 3,               // 使用哪一个 db，默认为 db0
    'timeout'    => 0,               // redis连接的超时时间
    'persistent' => false,           // 是否是长连接
2.修改connector中Reids类<br>
vendor/topthink/think-queue/src/queue/connector/Redis.php
<br>
将构造函数修改如下

    public function __construct($options)
    {
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
        $this->redis = new \Predis\Client([
            'scheme' => 'tcp',
            'host'   => $this->options['host'],
            'port'   => $this->options['port'],
            'auth'   => $this->options['password'],
            'timeout'   => $this->options['timeout'],
            'select'   => $this->options['select'],
        ]);
    }
   3.修改think-queue使用静态方法的问题
  <br>
  vendor/topthink/think-queue/src/queue/Worker.php
  
```
  //因为有用到hook或者config的地方，会报错提示no-static等问题需要如上
  Hook::listen
  Config::get
```
如下解决:<br>
```
  use think\facade\Hook;
  使用门面类，还需要注意写法，有的不能直接修改
  Config::pull 获取一级配置参数
```
4.work和listen的差别，使用场景
https://www.cnblogs.com/think-a-lot/p/10550939.html
