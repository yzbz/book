#!/usr/bin/env bash

cur_path=$(pwd);
echo $cur_path; #获取当前目录地址

shellDir=$(cd $(dirname $0); pwd)
#当前文件的所在目录


cur_name="${cur_path##*/}"
echo $cur_name; #当前文件名

#     #:表示从左开始算起，并且截取第一个匹配的字符
#
#     ##:表示从左开始算起，并且截取最后一个匹配的字符

#      %:表示从右开始算起，并且截取第一个匹配的字符

#      %%:表示从右开始算起，并且截取最后一个匹配的字符

if [ -z "$3" ]; then
    isTemp='yes'
else
    isTemp=$3
fi
echo $isTemp
#判断第三个参数是否为空，

echo $0; #当前文件的名字


pwd -p #显示真实路径，而非链接路径


