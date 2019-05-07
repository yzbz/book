<?php

/**
 * Class chat
 *
 * @package \\${NAMESPACE}
 */
class chat
{
    //保存服务链接句柄
    public $ws = null;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server("0.0.0.0", 9502);
        // 设置配置
        $this->set();
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on("close", [$this, "onClose"]);
        $this->ws->start();
    }

    public function set() {
        $this->ws->set(
            array(
                'daemonize' => false,      // 是否是守护进程
                'max_request' => 10000,    // 最大连接数量
                'dispatch_mode' => 2,
                'debug_mode' => 1,
                // 心跳检测的设置，自动踢掉掉线的fd
                'heartbeat_check_interval' => 5,
                'heartbeat_idle_time' => 600,
                'open_eof_check' => true, //打开EOF检测
                'package_eof' => "\r\n", //设置EOF
            )
        );
    }

    public function onOpen($ws, $request)
    {
        $ws->push($request->fd,  json_encode(['msg' => 'hello, welcome to chatroom'])."\n");

        echo $request->fd . "上线\n";
    }

    public function onMessage($ws, $frame)
    {
        $params = json_decode(($frame->data), true);
        var_dump($frame);
        if (empty($params['room_id'])) {
            $params['room_id'] = rand(10, 99);
        }
        $params['msg'] = $params['room_id'] . ':' . $params['msg'];
        // 分批次发送
        $start_fd = 0;
        while(true)
        {
            // connection_list函数获取现在连接中的fd
            $conn_list = $ws->connection_list($start_fd, 100);   // 获取从fd之后一百个进行发送
            var_dump($conn_list);
            echo 'conn_cnt' . count($conn_list);

            if($conn_list === false || count($conn_list) === 0)
            {
                echo "finish\n";
                return;
            }

            $start_fd = end($conn_list);

            foreach($conn_list as $fd)
            {
                $ws->push($fd, json_encode($params));
            }
        }
    }

    public function onClose($ws, $fd)
    {
        echo "client-{$fd} is closed\n";
        $ws->close($fd);   // 销毁fd链接信息
    }
}

$obj = new chat();
