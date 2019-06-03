#/bin/sh
#echo -e "当前日期是 `date`" >> record.txt
#/usr/bin/curl http://api.***.cn:88/Crontab/testUserEmpty  >> record.txt
#echo "this is mailtest" | mail -s "hello" 523631013@qq.com
str=`curl http://api.***.cn:88/Crontab/handleUserNameEmpty`
curTime=`date +"%Y-%m-%d %H-%M-%S"`
echo $curTime"     "$str >> /root/test/test_php/record.txt
