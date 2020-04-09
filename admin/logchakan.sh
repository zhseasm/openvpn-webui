#!/usr/bin/env bash
echo "查看某天ip日志，默认当天"
##showlog：哪个日志
##logtime：和access来拼接log名称
$showlog=access.log-$logtime
echo "ip连接数"
ipcount=$(cat /var/log/nginx/$showlog | awk '{print $2}' | sort | uniq -c | sort -nr)
echo "ip访问页面"
##showip：要查询的某个ip
$showip=""
cat access.log |grep $showip  | awk '{print $1"\t"$7}' | sort | uniq -c | sort -nr
echo "查看几小时内修改过的文件和权限"
##showtime：要查询的几小时内
$showtime=""
find /var/www/html/ -ctime -$showtime -and -perm 4755 -and -type f -exec ls -l {} \;
find /var/www/html/ -ctime -$showtime -and -perm 755 -and -type f -exec ls -l {} \;
find /var/www/html/ -ctime -$showtime -and -perm 644 -and -type f -exec ls -l {} \;
echo "隐藏权限"
find /var/www/html -ctime -$showtime -and -type f -exec lsattr {} \;
echo "尝试爆破ssh的ip"
grep "Failed password for root" /var/log/secure |awk '{print$11}'|sort |uniq -c |sort -nr
echo "爆破ssh的ip归属地查询"
grep "Failed password for root" /var/log/secure |awk '{print$11}'|sort |uniq -c |sort -nr |awk '{print $2}'|xargs -t -I {} curl 'http://freeapi.ipip.net/'{}
echo "成功登录的IP归属地查询"
grep "Accepted" /var/log/secure-20200223 |awk '{print $11}'|sort|uniq -c|sort -nr|awk '{print$2}'|xargs -t -I {} curl 'http://freeapi.ipip.net/'{}
