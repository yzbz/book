###PHP-FPM的三种工作模式和master进程和worker进程
> 前言：什么是php-fpm<br>
> PHP-FPM(FastCGI Process Manager：FastCGI进程管理器)是一个实现了Fastcgi的程序，并且提供进程管理的功能，被PHP官方收了。<br>
> php-fpm就是php中的FastCGI进程管理器。进程包括master进程和worker进程。master进程只有一个，负责管理子进程。<br>
> 详见可参考 <a href="https://blog.csdn.net/IT_10/article/details/92801153" target='_blank'>CGI、FastCGI和php-fpm概念和区别</a>  

####1. pm=static
 始终保持固定数量的worker进程数，由pm.max_children决定。

    [test]
    listen = 127.0.0.1:9001
    pm = static
    pm.max_children = 40

####2. pm=dynamic
  php-fpm启动时，会初始启动一些worker，初始启动worker数决定于pm.max_children的值。<br>
  在运行过程中动态调整worker数量，worker的数量受限于pm.max_children配置，同时受限全局配置process.max。
  
    [test]
    listen = 127.0.0.1:9001
    pm = dynamic
    pm.max_children = 40
    pm.start_servers = 2
    pm.min_spare_servers = 1
    pm.min_spare_servers = 6
1秒定时器作用，检查空闲worker数量，按照一定策略动态调整worker数量，增加或减少。<br>
增加时，worker最大数量<=max_children· <=全局process.max；<br>
减少时，只有idle >pm.max_spare_servers时才会关闭一个空闲worker。<br>

优缺点<br>
优点：动态扩容，不浪费系统资源<br>
缺点：如果所有worker都在工作，新的请求到来只能等待master在1秒定时器内再新建一个worker，这时可能最长等待1s<br>
    
####3. pm=ondemand
  php-fpm启动的时候，不会启动任何一个worker，而是按需启动，只有当连接过来的时候才会启动。<br>
  启动的最大worker数决定于pm.max_children的值，同时受限全局配置process.max。
  
    [test]
    listen = 127.0.0.1:9001
    pm = ondemand
    pm.max_children = 10
    pm.process_idle_timeout = 60
    
1秒定时器作用，如果空闲worker时间超过pm.process_idle_timeout的值（默认值为10s），则关闭该worker。这个机制可能会关闭所有的worker。<br>
增加时，worker最大数量<=max_children· <=全局process.max；<br>
减少时，只有idle >pm.max_spare_servers时才会关闭一个空闲worker。<br>

优缺点<br>
优点：按流量需求创建，不浪费系统资源<br>
缺点：由于php-fpm是短连接的，所以每次请求都会先建立连接，频繁的创建worker会浪费系统开销。<br>
所以，在大流量的系统上，master进程会变得繁忙，占用系统cpu资源，不适合大流量环境的部署。<br>

####master进程和worker进程
master只是负责监听管理工作，并不是很多人认为的把客户端发来的请求分给worker进程处理，而是由worker进程负责客户端的请求监听和处理<br>
 
eg1:<br>
可以看到只留下了worker进程，master进程被kill掉了,然后服务器访问php资源，可以访问到。<br>

eg2:<br>
kill掉worker进程，留下master进程<br>
可以看到一旦kill掉worker进程后，会重启一个新的worker进程。<br>
因此客户端请求肯定会得到响应处理。这进一步验证了的上面的结论，master进程负责监听子进程的状态，<br>
子进程挂掉之后，会发信号给master进程，然后master进程重新启一个新的worker进程<br>
