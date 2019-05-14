<?php

/**
 * Class chat
 *
 * @package \\${NAMESPACE}
 */

require __DIR__.'/extend/predis/autoload.php';
$redis = new Predis\Client(['host' => '118.89.249.169', 'port' => 6379]);


class chat
{
    //保存服务链接句柄
    public $ws = null;
    public $users = [];
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
                'heartbeat_check_interval' => 5, //五秒检查一次，
                'heartbeat_idle_time' => 600, //十分钟
                'open_eof_check' => true, //打开EOF检测
                'package_eof' => "\r\n", //设置EOF
            )
        );
    }

    public function onOpen($ws, $request)
    {
        $this->users = [ $request->fd => ['ip' => $request -> header['origin']]];
        $ws->push($request->fd,  json_encode(['data' => 'hello, welcome to chatroom', 'event_id' => 2])."\n");
        echo $request->fd . "上线\n";
    }

    public function onMessage($ws, $frame)
    {
        $params = json_decode(($frame->data), true);
        if ($params['event_id'] == 1) {
            $token = $this->getToken($frame->fd, $params['data']['username']);
            $GLOBALS['redis']->hmset('fd_' . $frame->fd, ['username' =>  $params['data']['username'], 'token' => $token]);
            $params['token'] = $token;
            $curUserList = $GLOBALS['redis']->keys('fd_*');
            foreach ($curUserList as $item) {
                $params['userList'][] = $GLOBALS['redis']->hget($item, 'username');
            }
        } else {
            $redisToken = $GLOBALS['redis']->hget('fd_' . $frame->fd, 'token');
            if ($redisToken == $params['token']) {
                echo '_checkLogin: success\n';
            } else {
                echo '_checkLogin: fail\n';
            }
        }
        // 分批次发送
        $start_fd = 0;
        if ($params['event_id'] == 2) {
            while(true)
            {
                $conn_list = $ws->connection_list($start_fd, 100);   // 获取从fd之后一百个进行发送
                echo 'conn_cnt:' . count($conn_list) . "\n";
                if($conn_list === false || count($conn_list) === 0)
                {
                    echo "群发完成\n";
                    return;
                }
                $start_fd = end($conn_list);
                $myMsg = '我:' . $params['data'];
                $params['data'] = $GLOBALS['redis']->hget('fd_' . $frame->fd, 'username') . ':' . $params['data'];
                foreach($conn_list as $fd)
                {
                    if ($fd == $frame->fd) {
                        $tmp = $params['data'];
                        $params['data'] = $myMsg;
                        $ws->push($fd, json_encode($params));
                        $params['data']  = $tmp;
                    } else {
                        $ws->push($fd, json_encode($params));
                    }
                }
            }
        } else if ($params['event_id'] == 1){
            $ws->push($frame->fd, json_encode($params));
            $start_fd = 0;
            while(true)
            {
                $params['event_id'] = 3;
                $conn_list = $ws->connection_list($start_fd, 100);   // 获取从fd之后一百个进行发送
                echo 'conn_cnt:' . count($conn_list) . "\n";
                if($conn_list === false || count($conn_list) === 0)
                {
                    echo "发送欢迎完成\n";
                    return;
                }
                $start_fd = end($conn_list);
                $params['data'] = '欢迎 ' . $GLOBALS['redis']->hget('fd_' . $frame->fd, 'username') . '加入群聊';
                foreach($conn_list as $fd)
                {
                    if ($fd != $frame->fd) {
                        $ws->push($fd, json_encode($params));
                    } else {
                        continue;
                    }
                }
            }
        }
    }

    public function onClose($ws, $fd)
    {
        $start_fd = 0;
        while(true)
        {
            $params['event_id'] = 4;
            $conn_list = $ws->connection_list($start_fd, 100);   // 获取从fd之后一百个进行发送
            echo 'conn_cnt:' . count($conn_list) . "\n";
            if($conn_list === false || count($conn_list) === 0)
            {
                echo "发送下线完成\n";
                return;
            }
            $start_fd = end($conn_list);
            $params['data'] = $GLOBALS['redis']->hget('fd_' .$fd, 'username') . '已下线';

            $curUserList = $GLOBALS['redis']->keys('fd_*');
            foreach ($curUserList as $item) {
                if ($item != 'fd_' .$fd) {
                    $params['userList'][] = $GLOBALS['redis']->hget($item, 'username');
                }
            }
            foreach($conn_list as $fd)
            {
                $ws->push($fd, json_encode($params));
            }
        }

        $GLOBALS['redis']->del('fd_' . $fd);
        echo "client-{$fd} is closed\n";
        $ws->close($fd);   // 销毁fd链接信息
    }

    public function getToken($fd, $username) {
        return  md5($fd + time() . $username . rand(100,9000));
    }


}

$obj = new chat();
