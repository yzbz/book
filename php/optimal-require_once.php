<?php
/**
 * Created by PhpStorm.
 * User: Baicai
 * Date: 2019/10/22
 * Time: 10:39
 */

// 优化的require_once
function require_cache($filename) {
    static $_importFiles = array();
    if (!isset($_importFiles[$filename])) {
        if (file_exists_case($filename)) {
            require $filename;
            $_importFiles[$filename] = true;
        } else {
            $_importFiles[$filename] = false;
        }
    }
    return $_importFiles[$filename];
}

/**
 *
 *  require： 引入一个文件，运行时编译引入.
 * require_once： 功能等同于require，只是当这个文件被引用过后，不再编译引入。
 *
 */