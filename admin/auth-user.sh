#!/usr/bin/env bash
#安装pam_mysql
rpm -Uvh http://repo.iotti.biz/CentOS/7/x86_64/pam_mysql-0.8.1-0.22.el7.lux.x86_64.rpm

#mysql部分
mysqladd="mysql --connect-expired-password -uroot -ptoor -e"
##降低安全度
#关于 mysql 密码策略相关参数；
#1）、validate_password_length  固定密码的总长度；
#2）、validate_password_dictionary_file 指定密码验证的文件路径；
#3）、validate_password_mixed_case_count  整个密码中至少要包含大/小写字母的总个数；
#4）、validate_password_number_count  整个密码中至少要包含阿拉伯数字的个数；
#5）、validate_password_policy 指定密码的强度验证等级，默认为 MEDIUM；
#关于 validate_password_policy 的取值：
#set global validate_password_policy=0
#0/LOW：只验证长度；
#1/MEDIUM：验证长度、数字、大小写、特殊字符；
#2/STRONG：验证长度、数字、大小写、特殊字符、字典文件；
#6）、validate_password_special_char_count 整个密码中至少要包含特殊字符的个数；

#dataname=openvpn
#name=openvpn
#pass=openvpn
#read -p"设置vpn数据库名:" dataname
#read -p"设置管理vpn的用户名:" name
#read -p"设置管理vpn的用户密码:" pass
$mysqladd "set global validate_password_policy=0;"
$mysqladd "set global validate_password_length=1;"
$mysqladd "flush privileges;"
$mysqladd "create database openvpn;"
$mysqladd "CREATE TABLE openvpn.vpnuser(name char(20)NOT NULL,password char(128) default NULL,active int(10) NOT NULL DEFAULT 1,PRIMARY KEY(name));"
$mysqladd "CREATE USER 'openvpn'@'%' IDENTIFIED BY 'openvpn';"
#$mysqladd "Grant ALL on *.* TO 'openvpn'@'%';"
$mysqladd "Grant ALL on  openvpn.vpnuser TO 'openvpn'@'%';"

#创建用户
#insert into vpnuser(name,password)values('zzzz',password('zzzz'));
#openvpn部分
#server.conf
cat >/etc/openvpn/server.conf<<eof
;监听的端口号 //需要
port 1194
;服务端用的协议，udp 能快点，所以我选择 udp
proto udp
;定义openvpn运行时使用哪一种模式，openvpn有两种运行模式一种是tap模式，一种是tun模式。
;tap模式也就是桥接模式，通过软件在系统中模拟出一个tap设备，该设备是一个二层设备，同时支持链路层协议。
;tun模式也就是路由模式，通过软件在系统中模拟出一个tun路由，tun是ip层的点对点协议。
dev tun
;定义openvpn在使用tun路由模式时，分配给client端分配的IP地址段
server 10.8.0.0 255.255.255.0
;push表示推送，即将配置推送给客户端，让客户端也使用subnet模式
push "topology subnet"
;这条命令可以重定向客户端的网关，在进行翻墙时会使用到
push "redirect-gateway def1 bypass-dhcp"
;向客户端推送的路由信息，如下内容表示客户端连接之后与当前互通
push "route 10.0.0.0 255.255.0.0"
;向客户端推送的DNS信息
push "dhcp-option DNS 10.8.0.1"
push "dhcp-option DNS 119.29.29.29"
push "dhcp-option DNS 114.114.114.114"
;telnet 管理地址 /etc/openvpn/management-pass第一行为密码
management localhost 1195 /etc/openvpn/management-pass
;防止密码被缓存到内存
auth-nocache
;等openvpn初始化完成后，降级为nobody权限进行
user nobody
group nobody
;定义活动连接保时期限
keepalive 10 300
;加密类型
cipher AES-256-CBC
;启用允许数据压缩，客户端配置文件也需要有这项
comp-lzo
;最多允许连接1000个客户端
max-clients 1000
;通过keepalive检测超时后，重新启动VPN，不重新读取keys，保留第一次使用的keys
persist-key
;通过keepalive检测超时后，重新启动VPN，一直保持tun或者tap设备是linkup的。否则网络连接，会先linkdown然后再linkup
persist-tun
;指定日志文件的记录详细级别，可选0-9，等级越高日志内容越详细9等级最高
verb 4
;重复日志记录限额
mute 20
;禁用TSL重协商
reneg-sec 0
;此选项开启只能使用udp协议。否则会报错error
explicit-exit-notify 1
;客户端1,服务端是0
key-direction 0
;2.4版本之前使用 tls-auth，如果高于此版本，则用tls-crypt，我用的2.4.8使用了tls-auth，结果连通之后无法访问外网了
tls-crypt /etc/openvpn/server/certs/ta.key 0
;记录客户端和虚拟ip地址之间的关系。在openvpn重启时,再次连接的客户端将依然被分配和断开之前的IP地址
ifconfig-pool-persist /etc/openvpn/ipp.txt
;使用客户提供的UserName作为Common Name
;这个选项开启了,不开启基于mysql认证可以进行用户名认证，随便输入什么密码,不开启默认使用用户名认证
;也可以只开启mysql认证，不需要开启这个选项
;username-as-common-name
;基于otp认证
;plugin /usr/local/lib/openvpn/openvpn-otp.so "password_is_cr=1 otp_secrets=/etc/openvpn/auth/otp-secrets"
;基于mysql进行认证，如不需要可注释掉,注释这个默认启用其他不需密码得认证
;plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn
;脚本登录
script-security 3
auth-user-pass-verify "/etc/openvpn/checkpsw.sh" via-env
;是否允许一个User同时登录多次，去掉本行注释后可以使用同一个用户名登录多次
;duplicate-cn
;CA 根证书路径
ca /etc/openvpn/server/certs/ca.crt
;open VPN 服务器证书路径
cert /etc/openvpn/server/certs/server.crt
;open VPN 服务器密钥路径
key /etc/openvpn/server/certs/server.key
;Diffie-Hellman 算法密钥文件路径
dh /etc/openvpn/server/certs/dh.pem
;指定 log 文件位置
log /var/log/openvpn/server.log
log-append /var/log/openvpn/server.log
status /var/log/openvpn/status.log
;吊销用户证书
crl-verify /etc/openvpn/easy-rsa/pki/crl.pem
;开启对客户端进行细粒度控制（该目录需要手动创建，名字为客户端的证书辨识名）
client-config-dir /etc/openvpn/ccd
;client-to-client
client-cert-not-required
eof


###验证部分
cat >/etc/pam.d/openvpn<<eof
auth sufficient /lib64/security/pam_mysql.so user=openvpn passwd=openvpn host=127.0.0.1 db=openvpn table=vpnuser usercolumn=name passwdcolumn=password where=active=1 sqllog=0 crypt=2
account required /lib64/security/pam_mysql.so user=openvpn passwd=openvpn host=127.0.0.1 db=openvpn table=vpnuser usercolumn=name passwdcolumn=password where=active=1 sqllog=0 crypt=2
#crypt(0)-- Used to decide to use MySQL's PASSWORD() function or crypt()
#0= No encryption. Passwords in database in plaintext. NOT recommended!
#1= Use crypt
#2= Use MySQL PASSWORD() function
#3=：表示使用md5的散列方式
eof

##测试连接是否正常
#创建测试用户
mysql --connect-expired-password -uopenvpn -popenvpn -e "insert into openvpn.vpnuser(name,password)values('zzzz',password('zzzz'));"
#安装saslauthd
yum install cyrus-sasl-2.1.26-23.el7.x86_64 -y
systemctl restart saslauthd
testsaslauthd -u zzzz -p zzzz -s openvpn

#otp
yum install -y openvpn-devel openvpn autoconf automake libtool libssl-dev openssl-devel
./autogen.sh
./configure --prefix=/usr
make install
./configure --with-openvpn-plugin-dir=/plugin/dir
mkdir -p /etc/openvpn/
touch /etc/openvpn/auth/otp-secrets
#script
cat >/etc/openvpn/checkpsw.sh<<eof
#!/bin/sh
###########################################################
# checkpsw.sh (C) 2004 Mathias Sundman <mathias@openvpn.se>
#
# This script will authenticate OpenVPN users against
# a plain text file. The passfile should simply contain
# one row per user with the username first followed by
# one or more space(s) or tab(s) and then the password.

PASSFILE="/etc/openvpn/psw-file"
LOG_FILE="/var/log/openvpn-password.log"
TIME_STAMP=\`date "+%Y-%m-%d %T"\`

###########################################################

if [ ! -r "\${PASSFILE}" ]; then
  echo "\${TIME_STAMP}: Could not open password file \"\${PASSFILE}\" for reading." >> \${LOG_FILE}
  exit 1
fi

CORRECT_PASSWORD=\`awk '!/^;/&&!/^#/&&\$1=="'\${username}'"{print \$2;exit}' \${PASSFILE}\`

if [ "\${CORRECT_PASSWORD}" = "" ]; then
  echo "\${TIME_STAMP}: User does not exist: username=\"\${username}\", password=\"\${password}\"." >> \${LOG_FILE}
  exit 1
fi

if [ "\${password}" = "\${CORRECT_PASSWORD}" ]; then
  echo "\${TIME_STAMP}: Successful authentication: username=\"\${username}\"." >> \${LOG_FILE}
  exit 0
fi

echo "\${TIME_STAMP}: Incorrect password: username=\"\${username}\", password=\"\${password}\"." >> \${LOG_FILE}
exit 1
eof
chmod a+x /etc/openvpn/checkpsw.sh
touch /etc/openvpn/psw-file
chmod 644 /etc/openvpn/psw-file
echo done
exit 0