# -*- coding: utf-8 -*-
import os
import oss2

# 首先初始化AccessKeyId、AccessKeySecret、Endpoint等信息。
# 通过环境变量获取，或者把诸如“<你的AccessKeyId>”替换成真实的AccessKeyId等。
#
access_key_id = os.getenv('OSS_TEST_ACCESS_KEY_ID', 'DvJIvpy9KFJVH1wm')
access_key_secret = os.getenv('OSS_TEST_ACCESS_KEY_SECRET', 'VI8TF7qk4erXrFtEXr9s6mPPPuLrdv')
bucket_name = os.getenv('OSS_TEST_BUCKET', 'zhenmuwang')
endpoint = os.getenv('OSS_TEST_ENDPOINT', 'oss-cn-beijing.aliyuncs.com')


# 确认上面的参数都填写正确了
for param in (access_key_id, access_key_secret, bucket_name, endpoint):
    assert '<' not in param, '请设置参数：' + param

# 创建Bucket对象，所有Object相关的接口都可以通过Bucket对象来进行
bucket = oss2.Bucket(oss2.Auth(access_key_id, access_key_secret), endpoint, bucket_name)

# 上传一段字符串。Object名是motto.txt，内容是一段名言。去根目录下找，或者直接访问就能确认是否上传成功
# bucket.put_object('motto.txt2', 'cont is empty')

def scran_file(path):
    file_list = fileListFunc(path)
    print(file_list)
    n = 500
    for file in file_list:
        if file.find('.jpg') != -1:
            n += 1
            print(file)
            object_name = '202007_mtp_big_' + str(n) + '.' + file.split('\\')[-1].split('.')[1]
            bucket.put_object_from_file(object_name, file)
            print(object_name)
        else:
            print('is other file')

def fileListFunc(filePathList):
    fileList = []
    for filePath in filePathList:
        for top, dirs, nondirs in os.walk(filePath):
            for item in nondirs:
                fileList.append(os.path.join(top, item))
    return fileList

scran_path_list=[r"C:\Users\Baicai\img"]
scran_file(scran_path_list)

