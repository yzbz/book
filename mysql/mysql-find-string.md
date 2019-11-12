###Mysql 判断字符串中是否包含某个字符

#####1. like

    SELECT * FROM 表名 WHERE 字段名 like "%字符%";
 
#####2. find_in_set(字符, 字段名)

    SELECT * FROM users WHERE find_in_set('字符', 字段名);

字符串函数 find_in_set(str1, str2)函数是返回str2中str1所在的位置，str2必须以","分割开

#####3.locate(字符, 字段名)
locate(字符,字段名)函数，如果包含，返回Index，否则返回0

别名 position in
    
    select * from 表名 where locate(字符,字段)
    select * from 表名 where position(字符 in 字段);

####4.INSTR(字段, 字符)

    select * from 表名 where INSTR(字段,字符)

在字符串STR里面,字符串SUBSTR出现的第一个位置(INDEX)，INDEX是从1开始计算，如果没有找到就直接返回0，没有返回负数的情况。