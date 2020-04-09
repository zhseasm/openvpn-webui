#!/bin/bash

if [ "$EUID" -ne 0 ]; then
	echo "请用root用户安装";
	exit
fi


####nginx
rpm -Uvh http://nginx.org/packages/centos/7/noarch/RPMS/nginx-release-centos-7-0.el7.ngx.noarch.rpm
yum install -y nginx vim net-tools

#####php73
yum install -y epel-release wget

rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm

rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm

yum install -y yum-utils

yum install -y php73-php-fpm php73-php-cli php73-php-bcmath php73-php-gd php73-php-json php73-php-mbstring php73-php-mcrypt php73-php-mysqlnd php73-php-opcache php73-php-pdo php73-php-pecl-crypto php73-php-pecl-mcrypt php73-php-pecl-geoip php73-php-recode php73-php-snmp php73-php-soap php73-php-xml

####mysql
rpm -Uvh http://repo.mysql.com/mysql57-community-release-el7-8.noarch.rpm
yum install -y mysql mysql-server


setenforce 0

mkdir -p /var/www/html

cat >> /var/www/html/phpinfo.php<<eof
<?php
phpinfo();
?>
eof

cd /etc/nginx
mv nginx.conf nginxbak
#cp nginx.conf nginxbak
#sed -i '32s/}//g' nginx.conf
#cat >> nginx.conf <<eof
#}
#eof

curl -o nginx.conf https://s.01self.tk/usr/uploads/2020/02/1738454018.conf
chown -R nginx:nginx /var/www/html/
systemctl restart nginx
systemctl enable nginx

grep "cgi.fix_pathinfo=1*" /etc/opt/remi/php73/php.ini |sed -i 's/\;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' /etc/opt/remi/php73/php.ini
cd /etc/opt/remi/php73/php-fpm.d/
grep "user = apache" www.conf |sed -i 's/user = apache/user = nginx/g' www.conf
grep "group = apache" www.conf |sed -i 's/group = apache/group = nginx/g' www.conf
chown -R root:nginx /var/opt/remi/php73/lib/php/
systemctl restart php73-php-fpm
systemctl enable php73-php-fpm

#echo "你的mysql初始密码为，如果要更改密码，请使用"
#cat /var/log/mysqld.log |grep "temporary password"|cut -d : -f 4

systemctl restart mysqld
systemctl enable mysqld
sleep 1

yum install wget -y
cd /etc/yum.repos.d/
rename repo repo.bak *
wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo
wget -O /etc/yum.repos.d/epel.repo http://mirrors.aliyun.com/repo/epel-7.repo
yum clean
yum makecache



defaultmysqlpwd=`grep 'A temporary password' /var/log/mysqld.log | awk -F"root@localhost: " '{ print $2}' `
mysql --connect-expired-password -uroot -p$defaultmysqlpwd -e "set global validate_password_policy=0;"
mysql --connect-expired-password -uroot -p$defaultmysqlpwd -e "set global validate_password_length=4;"
mysqladmin -uroot -p$defaultmysqlpwd password toor
sleep 1
systemctl restart mysqld
sleep 1
firewall-cmd --permanent --zone=public --add-port=80/tcp
systemctl restart firewalld
echo -e "\033[1m\n          lnmp环境已经安装好\n可以通过http://ip地址/phpinfo.php 来访问你的phpinfo \n           mysql密码为toor\n"

exit 0