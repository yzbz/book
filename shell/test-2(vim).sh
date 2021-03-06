#!/usr/bin/env bash
# vim
插入
i #当前插入
I #行首插入
a #当前字符后插入
A #行后插入
o 下一行插入
O 上一行插入

x 删除后一个字符
X 删除前一个字符
dd 删除
ndd 删除n行

yy 复制
nyy 复制n行

p 粘贴

dw 删除一个词
yw 复制一个词
y^ 复制到头
y$ 复制到尾

gg 文章首
GG 文章尾

/serach 搜索内容
n 下一个搜索内容
N 上一个

:set nu  显示行数
:set nonu 隐藏行

j 下
k 上
h 左
l 右
ctrl+u 向前半页
ctrl+d 向后半页

ctrl+f 前一页
ctrl+b 后一页

w 后一个单词
b 前一个单词
c+^ 删除到行头
c+$ 删除到行尾

u 撤回上一步操作

ls a*  查询a开头的 当前目录下所有的问题
ls -l *.php 查询当前目录下.php扩展名的文件
cp -a docs newdocs 递归性复制docs目录下的所有文件到newdocs中

cd 等同于 cd ~

cp -r /doc /newdoc  复制目录

tree 查看目录结构

vim 的三种模式
命令行模式
末行模式
编辑模式

bash
ctrl+r 搜索历史命令

history 历史命令
!n 执行历史命令中的某条

ctrl+l 清屏幕
ctrl+w 删除键入的最后一个单词
ctrl+u 删除行内光标前的字符

#替换
:{作用范围}s/{目标}/{替换}/{替换标志}

#作用范围
#作用范围分为当前行、全文、选区等等。
#当前行：
:s/foo/bar/g
#全文：
:%s/foo/bar/g
#2-11行：
:5,12s/foo/bar/g

review
vim
u 回退上一步
$到结尾
^到开头

ctrl+r 搜索历史命令
ctrl+u 前半页
ctrl+d 后半页
cd ~ = cd
w 后一个单词
b 前一个单词

