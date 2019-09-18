
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