# mysql百万条数据如何删除重复项

* 1.使用select id from table_name group by field （通过group by 去重, 将结果中的id导出保存txt）
* 2.通过一门后台语音php、python都可，将txt导入保存成array
* 3.遍历原表每次使用limit，依次判断记录id是否在array中（不在即删）
* 4.第一步可使用max或min函数
* 5.第三步可以采用存储到同一个array整体删除
