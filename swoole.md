
 **1\. 概念** 
``` 
1.子进程会复制父进程的内存空间，他们之间不会影响
2.swoole多进程模型，进程间变量不能通用
3.实现进程间通信，1种方式，使用共享内存
4.共享内存不属于进程内存，可以被任意进程访问
5.ipcs-m  可以查看共享内存分片
6.fpm主要影响性能的原因是始终忙于创建进程和销毁进程
7.swoole结构 第一层是master层，含有很多reacter线程，第二层是manager主要负责进程的分配，不参与业务逻辑，master进程获取到数据会通过 管道投递到worker进程和task进程，可以修改不使用管道改为走系统任务队列

 ```
 **2\. task 进程** 
``` 
1.属于工作进程，处理耗时过长的进程，不影响worder进程来自客户端的请求
    2.在ontask时进程业务处理
    3.task传递数据的大小，小于8k直接使用管道传递，否则被存在_tmp目录下，临时文件
    4.传递对象，使用序列表传递对象的拷贝，task进程改变worder进程的对象，不会反应到worder进程
    5.task的onfinish回到，回到给调用task的投递worder进程，保证走进走回，
    6.onWorderStart方法中可以通过$ser->tastWorder判断是worder进程还是taskworder进程
    7.
 ```
  **3\. timer定时器** 
 ``` 
1.使用堆存放，最小堆的形式，剩余时间越少的越靠近对顶，提高检索效率
2.最大堆，最小堆和二叉树的区别，左子书，父级间大小关系
2.swoole_timer_tick(num,callback,params)永久定时器
3.swoole_timer_after(num,callback,params)，一次定时器
4.swoole_timer_clear 清楚定时器
  ```
