#!/usr/bin/env bash
dirfile=$(find / -name "*openvpn-webui*")
cd /var/www/html
#git clone https://github.com/zhseasm/openvpn-webui.git
mv $dirfile/* .
cd /var/www/html/sql
mysql --connect-expired-password -uroot -ptoor -e "create database rbac;"
mysql -uroot -ptoor rbac <rbac.sql
mkdir -p /var/www/html/download
/usr/sbin/iptables -F
exit 0
