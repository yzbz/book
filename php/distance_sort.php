<?php
/**
 * Created by PhpStorm.
 * User: Baicai
 * Date: 2019/10/11
 * Time: 14:16
 */

//使用mysql进行根据经纬度排序

$distanct = sprintf("round(6378.138 * 2 * asin(sqrt(pow(sin((%f * pi() / 180 - goods.lat * pi() / 180) / 2),2) + cos(%f * pi() / 180) * cos(goods.lat * pi() / 180) * pow(sin((%f * pi() / 180 - goods.lng * pi() / 180) / 2),2)))* 1000)", $lat, $lat, $lng);
$fields[$distanct] = 'distance';
