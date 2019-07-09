###thinkphp使用getBy，getField,geFieldBy的用法
####以下是getBy的使用
#####假设数据库中user表有如下字段:id,name,logo。在user表中找到id为1的一列。返回的是一个索引数组。如果符合条件的是多行数据，默认只取第一行;  
  
       public function test()
       {
            $data = M('user')->getByid(1);
           $data = M('user')->getByName('小明');
           $data = M('user')->getByLogo('a.jpg');
            //这两个同理第一个查询
           $data = M('user')->find(1);//和$data = M('user')->getByid(1);
           #找到的结果是一样的，但是要求id是主键
       }
####以下是getField的使用
##### 找到表中name字段等于小明的的user_id的值，返回的直接是id的值。如果条件找到多个的话默认取第一个 
       public function test()
       {
            $result = M('users')->where(['name'=>'小明'])->getField('id');
       }
    
##### getField方法通常是伴随where条件使用的，如果没有where条件。默认返回查询结果的第一条
如果需要返回多条符合条件的值在getField方法中的参数后面加个true参数。getField(‘id’,true);
返回的数据是一维的索引数组。
```
$result = M('users')->where(['name'=>'小明'])->getField('id'，true);
```
#####如果需要获取多个字段的话使用getField(‘id,name,logo’);同理要获取多条符合条件的值，请设置第二个参数，返回的一维数组中key值是getField方法中第一个参数的值。

####以下是getFieldBy的使用
#####假设数据库中user表有如下字段:id,name,logo。在user表中找到id为1的一列。返回的是一个索引数组。如果符合条件的是多行数据，默认只取第一行;  
  ```
      $data = M('user')->getFieldByName('小明','id');//根据user表中的name字段找到name的值为小明的一列，并返回他的id值。
  ```

