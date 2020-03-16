# mysql百万数据删除卡顿，执行命令以后一直卡住问题
### 1.先查看进程：

show full processlist; 
列出当前的操作process，看到了很多waiting的process，说明已经有卡住的proces了。

### 2.查看正在执行的线程，并按 Time 逆排序
select * from information_schema.processlist where Command != 'Sleep' order by Time desc;
### 3.找出所有执行时间超过 5 分钟的线程，拼凑出 kill 语句，方便后面查杀

select concat('kill ', id, ';') from information_schema.processlist where Command != 'Sleep' and Time > 300 order by Time desc;

### 4.使用kill杀进程，重启mysql，就可以正常操作了

kill processid杀死进程

如：kill 666 表示上面查询得到的id
