<?php

$str1 = '2';
$str2 = '1';
//echo 和print的差别，print有返回值，始终返回1，但是只能打印一个字符,echo 返回值赋给变量报错，print打印多个字符报错
echo $str1,$str2;
$res = print $str1;

$arr = ['name' => 'z3', 'age'=>18];

print_r($arr); //按照易于理解的方式打印出来
var_dump($arr,$str1); //可以打印多个函数，字符串，

//input digit 可以在移动端出现带小数点的小键盘

//定义一个常量，最后一个参数来区分是否严格判断大小写
define("GREETING", 'welcome to china', true);

$str3 = "hello world";
//删除字符串右侧的空白和特殊字符，或者有指定字符，删除最右侧的指定字符
$newStr = chop($str3, 'ld');
var_dump($newStr);
//sprintf($str,$arg,$arg),后面的参数一次替换%好的位置
$number = 9;
$str = "Beijing";
$txt = sprintf("There are %u million bicycles in %s.",$number,$str);
echo $txt;  //There are 9 million bicycles in Beijing.

//join是implode的表名，都是讲数组组合成字符串
$res = join(",", $arr);

//strrev 反正字符串
echo "\n";
echo strrev($txt);
echo "\n";

$str = 'hello shanghai';
//替换第二个字符在第一个字符串中的位置，并替换，
echo strtr($str, "hai", "h1");//的三个字符串，不够不补，多余删除

ucwords($str); //字符串中的所有单词的首字母大写
ucfirst($str); //字符串中的首字母大写

echo PHP_EOL;//提高代码可移植性，换行符

//三种数组类型，数值型，关联型，多维数组
$arr1 = [];
array_column($arr); //返回数组中单一列的值
array_chunk($arr); // 将数组分片
array_diff($arr,$arr1);//根据数组的值进行比较

array_key_exists('name', $arr); //判断指定的key是否存在数组中

array_rand($arr, 3);//随机返回数组中的几条记录，返回的是key
array_search('red', $arr); //搜索值所在的key并返回
