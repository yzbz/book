
 **1\. 删除重复记录** 
``` 
    delete from `repeat` where id in (
        select * from (SELECT id from `repeat` group by val HAVING count(*) > 1) b
    )
    
    总结：把结果集当作一个表，自我查询一遍
    格式为：SELECT *  FROM （） as n_tab
 
 ```
   
                   (结果集)a
  **2\. 自增变量使用** 
 ``` 
     SELECT * FROM
     (SELECT ID,(@i:=@i+1) AS i FROM sps_posts,(SELECT @i:=0) AS it WHERE post_status='publish') temp
 
  ```
**3\. MySQL中的字符序命名惯例** 


    以字符序对应的字符集名称开头；
    以_ci(表示大小写不敏感)、
    _cs(表示大小写敏感)、
    或_bin(表示按编码值比较)结尾。
    
    例如：在字符序“utf8_general_ci”下，字符“a”和“A”是等价的
    