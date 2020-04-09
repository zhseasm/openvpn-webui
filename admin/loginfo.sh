#!/usr/bin/env bash
echo "当日ip连接数"
cat /var/log/nginx/access.log|awk '{print $2}' |sort |uniq -c|awk '{print $1}'
exit 0
echo "访问前10的ip"
cat /var/log/nginx/access.log|awk '{print $1}' |sort | cat /var/log/nginx/access.log|awk '{print $1}' |sort|uniq -c|sort -nr|head -n 10
exit 0
echo "访问量前10的页面"
cat /var/log/nginx/access.log|awk '{print$7}'|sort|uniq -c|sort -nr|head -n 10
exit 0
echo "24小时内修改过的文件和权限"
find /var/www/html/ -ctime -24 -and -perm 4755 -and -type f -exec ls -l {} \;
#echo "隐藏权限"
#find /var/www/html -ctime -24 -and -type f -exec /usr/bin/lsattr {} \;|sort|head
exit 0
#exit 0
find /var/www/html/ -ctime -3 -and -perm 755 -and -type f -exec ls -l {} \;
exit 0
find /var/www/html/ -ctime +30 -and -perm 644 -and -type f -exec ls -l {} \;
exit 0
echo "尝试爆破ssh的ip"
grep "Failed password for root" /var/log/secure |awk '{print$11}'|sort |uniq -c |sort -nr
echo "登录ssh成功的ip"
grep "Accepted" /var/log/secure |awk '{print $11}'|sort |uniq -c|sort -rn
exit 0
echo "爆破ssh的ip归属地查询"
grep "Failed password for root" /var/log/secure |awk '{print$11}'|sort |uniq -c |sort -nr |awk '{print $2}'|xargs -t -I {} curl 'http://freeapi.ipip.net/'{}
echo ""
echo "成功登录的IP归属地查询"
grep "Accepted" /var/log/secure |awk '{print $11}'|sort|uniq -c|sort -nr|awk '{print$2}'|xargs -t -I {} curl 'http://freeapi.ipip.net/'{}
exit 0
