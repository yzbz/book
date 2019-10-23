
MySQL默认采用自动提交（AUTOCOMMIT）模式，不是显示的开启一个事务，每个查询都被当作一个事务执行提交操作。

在当前连接中，可以通过设置AUTOCOMMIT变量来开启或者禁用自动提交功能。

    mysql> show variables like 'AUTOCOMMIT';
    +---------------+-------+
    | Variable_name | Value |
    +---------------+-------+
    | autocommit    | ON    |
    +---------------+-------+
    1 row in set
1或者ON表示开启；0或者OFF表示禁用。

    mysql> set autocommit = 0;
    Query OK, 0 rows affected 
    
<br>

    mysql> show variables like 'AUTOCOMMIT';
    +---------------+-------+
    | Variable_name | Value |
    +---------------+-------+
    | autocommit    | OFF   |
    +---------------+-------+
    1 row in set
当 autocommit = 0 时，所有的查询都在一个事务中，直到显示的执行 commit 进行提交或者 rollback 进行回滚，该事务才最终结束，同时开启了另一个事务。