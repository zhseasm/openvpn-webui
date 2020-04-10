cd /var/www/html
git clone https://github.com/zhseasm/openvpn-web.git
mv openvpn-web/* .
cd /var/www/html/sql
mysql --connect-expired-password -uroot -ptoor -e "create database rbac;"
mysql -uroot -ptoor rbac <rbac.sql
iptables -F
exit 0