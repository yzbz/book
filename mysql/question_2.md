# mysql百万条数据如何删除重复项

* 1.使用select id from table_name group by field （通过group by 去重, 将结果中的id导出保存txt）
* 2.通过一门后台语音php、python都可，将txt导入保存成array
* 3.遍历原表每次使用limit，依次判断记录id是否在array中（不在即删）
* 4.第一步可使用max或min函数
* 5.第三步可以采用存储到同一个array整体删除

#### notice: 
* 1.如果设计到in或not in太大的问题，将两个结果集的id导出用后台语言取差集就可以实现not in的功能
* 2.注意php的内存大小，会存在数据量太大，内存超出直接崩的效果，建议使用php7
