###关于join的笔记

* inner join 可以简写成join，join分为三种方式：
等值连接on a.id=b.id
不等值连接 on a.age>b.age
自连接 user_tab a join on user_tab b on a.id=b.id

全连接理论存在
可以使用左连接和右连接通过union连接实现
