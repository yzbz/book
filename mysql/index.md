###索引相关记录1
在groupby和order by时尽可能使用一个表的记录这样会使用到索引
在分组时如何不需要排序那么可以使用order by null来不进行文件排序
