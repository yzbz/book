###PHP中查找数组元素查找和去重的效率技巧
####以下是通过执行速度来比较数组中查找元素和去重的问题
1.php in_array()方法说明

```
in_array(search,array,type)
```
参数说明 <br>
type为true是区分大小写的比较

2.in_array()查找元素效率<br>
例如：使用in_array()对有10万个元素的数组进行1000次比较
<br>
```
<?php

$arr = [];
//创建10万个元素
for ($i = 0;$i < 100000; $i++) {
    $arr[] = $i;
}

$starttime = getMicrotime();

//创建1000个数组使用in_array比较

for ($i = 0; $i < 1000; $i++) {
    $str = mt_rand(1, 99999);
    in_array($str, $arr);
}

$endtime = getMicrotime();

echo 'run time:' . (float) (($endtime - $starttime) * 1000) . 'ms';

function getMicrotime(){
    list($usec, $sec) = explode(' ', microtime());
    return (float)$usec + (float)$sec;
}

//php7.1 run time:91.511964797974ms
//php5.6 run time:806.10203742981ms

```
使用 in_array 在10万个元素的数组中比较1000次，运行时间需要约0.91秒

3.提高查找元素效率方法
  <br>
  我们可以先使用array_flip进行键值互换，然后使用isset方法来判断元素是否存在，这样可以提高效率
```
<?php

$arr = [];
//创建10万个元素
for ($i = 0;$i < 100000; $i++) {
    $arr[] = $i;
}

$starttime = getMicrotime();
$arr = array_flip($arr);
//创建1000个数组使用in_array比较

for ($i = 0; $i < 1000; $i++) {
    $str = mt_rand(1, 99999);
    isset($arr[$str]);
}

$endtime = getMicrotime();

echo 'run time:' . (float) (($endtime - $starttime) * 1000) . 'ms';

function getMicrotime(){
    list($usec, $sec) = explode(' ', microtime());
    return (float)$usec + (float)$sec;
}

//php7.1 run time:3.5009384155273ms
//php5.6 run time:797.60098457336ms
?>

```
使用array_flip与isset判断元素是否存在，在10万个元素的数组中比较1000次，运行时间需要约3.5毫秒
     
###因此，对于大数组进行比较，使用array_flip与isset方法会比in_array效率高很多。
4.array_unique() 去重的效率

```
<?php
$arr = array();

// 创建100000个随机元素的数组
for($i=0; $i<100000; $i++){
  $arr[] = mt_rand(1,99);
}

// 记录开始时间
$starttime = getMicrotime();

// 去重
$arr = array_unique($arr);

// 记录结束时间
$endtime = getMicrotime();

$arr = array_values($arr);

echo 'unique count:'.count($arr).'<br>';
echo 'run time:'.(float)(($endtime-$starttime)*1000).'ms<br>';
echo 'use memory:'.getUseMemory();

/**
 * 获取使用内存
 * @return float
 */
function getUseMemory(){
  $use_memory = round(memory_get_usage(true)/1024,2).'kb';
  return $use_memory;
}

/**
 * 获取microtime
 * @return float
 */
function getMicrotime(){
  list($usec, $sec) = explode(' ', microtime());
  return (float)$usec + (float)$sec;
}
?>

```
unique count:99<br>run time:82.009792327881ms<br>use memory:2048kb<br>

5.更快的去重方法,使用array_flip的方式去重
```
<?php
$arr = array();

// 创建100000个随机元素的数组
for($i=0; $i<100000; $i++){
    $arr[] = mt_rand(1,99);
}
// 记录开始时间
$starttime = getMicrotime();

// 使用键值互换去重
$arr = array_flip($arr);
$arr = array_flip($arr);

// 记录结束时间
$endtime = getMicrotime();

$arr = array_values($arr);

echo 'unique count:'.count($arr).'<br>';
echo 'run time:'.(float)(($endtime-$starttime)*1000).'ms<br>';
echo 'use memory:'.getUseMemory();

/**
 * 获取使用内存
 * @return float
 */
function getUseMemory(){
    $use_memory = round(memory_get_usage(true)/1024,2).'kb';
    return $use_memory;
}

/**
 * 获取microtime
 * @return float
 */
function getMicrotime(){
    list($usec, $sec) = explode(' ', microtime());
    return (float)$usec + (float)$sec;
}
?>

```
unique count:99<br>run time:1.4998912811279ms<br>use memory:2048kb
