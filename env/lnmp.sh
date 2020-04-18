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

cat >/etc/nginx/nginx.conf<<eof

# For more information on configuration, see:
#   * Official English Documentation: http://nginx.org/en/docs/
#   * Official Russian Documentation: http://nginx.org/ru/docs/

user nginx;
worker_processes auto;
error_log /var/log/nginx/error.log;
pid /run/nginx.pid;

# Load dynamic modules. See /usr/share/nginx/README.dynamic.
include /usr/share/nginx/modules/*.conf;

events {
    worker_connections 1024;
}

http {
    log_format  main  '\$remote_addr - \$remote_user [\$time_local] "\$request" '
                      '\$status \$body_bytes_sent "\$http_referer" '
                      '"\$http_user_agent" "\$http_x_forwarded_for"';

    access_log  /var/log/nginx/access.log  main;

    sendfile            on;
    tcp_nopush          on;
    tcp_nodelay         on;
    keepalive_timeout   65;
    types_hash_max_size 2048;

    include             /etc/nginx/mime.types;
    default_type        application/octet-stream;

    # Load modular configuration files from the /etc/nginx/conf.d directory.
    # See http://nginx.org/en/docs/ngx_core_module.html#include
    # for more information.
    include /etc/nginx/conf.d/*.conf;
    fastcgi_intercept_errors on;
    server {
        listen       80 default_server;
        #listen       [::]:80 default_server;
        server_name _;
        root         /var/www/html/view;
        index index.php index.html index.htm; #此处为新增
        error_page 404 = /404.php;


listen 443 ssl;

ssl_certificate /etc/nginx/key/ssl.crt;

ssl_certificate_key /etc/nginx/key/ssl.pem;

ssl_protocols TLSv1 TLSv1.1 TLSv1.2;

ssl_ciphers "EECDH+ECDSA+AESGCM EECDH+aRSA+AESGCM EECDH+ECDSA+SHA384 EECDH+ECDSA+SHA256 EECDH+aRSA+SHA384 EECDH+aRSA+SHA256 EECDH+aRSA+RC4 EECDH EDH+aRSA !aNULL !eNULL !LOW !3DES !MD5 !EXP !PSK !SRP !DSS !RC4";

keepalive_timeout 70;

ssl_session_cache shared:SSL:10m;

ssl_session_timeout 10m;
if (\$server_port = 80){
return 301 https://\$http_host\$request_uri;}
 #rewrite (.*) https://192.168.31.121\$1 permanent;}
 if (\$scheme = http){

# rewrite (.*) https://192.168.31.121\$1 permanent;i}
return 301 https://\$http_host\$request_uri;}
#error_page 497 https://\$server_name\$request_uri;}

        # Load configuration files for the default server block.
        include /etc/nginx/default.d/*.conf;

        location / {

 #rewrite (.*) https://192.168.31.121\$1 permanent;
        }

        error_page 404 /404.html;
            location = /40x.html {
        }

        error_page 500 502 503 504 /50x.html;
            location = /50x.html {
        }
        location ~ .php$ {   #此处为新增
            try_files \$uri =404;
            root /var/www/html/view;
            fastcgi_pass 127.0.0.1:9000;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
            include fastcgi_params;
        }
    }
}
eof



#curl -o nginx.conf https://github.com/zhseasm/openvpn-web/blob/master/env/nginx.conf
chown -R nginx:nginx /var/www/html/
echo "nginx ALL=NOPASSWD:/bin/bash">> /etc/sudoers
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
##key
mkdir -p /etc/nginx/key
cd /etc/nginx/key/
openssl genrsa -out ssl.pem 4096
openssl req -new -key ssl.pem -out ssl.csr
openssl x509 -req -in ssl.csr -out ssl.crt -signkey ssl.pem -CAcreateserial -days 3650
echo -e "\033[1m\n          lnmp环境已经安装好\n可以通过http://ip地址/phpinfo.php 来访问你的phpinfo \n           mysql密码为toor\n"

exit 0