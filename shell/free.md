###free命令

free命令是用来查看内存占用情况, -m表示以M为单位显示, -h表示以方便阅读的方式显示


    root@000504e77202:/opt# free
                 total       used       free     shared    buffers     cached
    Mem:       1019980     565644     454336     167536      31808     204936
    -/+ buffers/cache:     328900     691080
    Swap:      1193056          0    1193056
    root@000504e77202:/opt# free -m
                 total       used       free     shared    buffers     cached
    Mem:           996        552        443        163         31        200
    -/+ buffers/cache:        321        674
    Swap:         1165          0       1165
    root@000504e77202:/opt# free -h
                 total       used       free     shared    buffers     cached
    Mem:          996M       552M       443M       163M        31M       200M
    -/+ buffers/cache:       321M       674M
    Swap:         1.1G         0B       1.1G
    root@000504e77202:/opt#



####参数说明：
  
       total 内存总数
       used 已经使用的内存数
       free 空闲的内存数
       shared 不必关心
       buff/cache 缓存内存数
       
       说明: buff/cache分为used和free两部分, free部分是可以回收的内存
       total = used + free + buff/cache
