#!/usr/bin/env bash
stty erase '^H'

######安装openvpn######
function installopenvpn() {
echo "正在开始安装openvpn"
yum -y install epel-release
yum -y install openvpn easy-rsa  zip unzip net-tools-2.0-0.25.20131004git.el7.x86_64 python python2-pip lsof
pip install lolcat
mkdir -p /etc/openvpn/easy-rsa/
cp -a /usr/share/easy-rsa/3/* /etc/openvpn/easy-rsa
cd /etc/openvpn/easy-rsa
cat >>vars << eof   //下面都需要
export KEY_COUNTRY="CN"
export KEY_PROVINCE="SC"
export KEY_CITY="ChengDu"
export KEY_ORG="ERYAJF, Inc"
export KEY_EMAIL="1823590952@qq.com"
export KEY_CN=vpn.net
export KEY_NAME=vpnserver
export KEY_OU=sichuan
eof
source ./vars
./easyrsa init-pki
./easyrsa build-ca nopass  //需要common name
./easyrsa build-server-full server nopass  //需要证书名称server
./easyrsa gen-dh
./easyrsa gen-crl
openvpn --genkey --secret ta.key
mkdir /etc/openvpn/server/certs && cd /etc/openvpn/server/certs
cp /etc/openvpn/easy-rsa/pki/dh.pem ./
cp /etc/openvpn/easy-rsa/pki/ca.crt ./
cp /etc/openvpn/easy-rsa/pki/issued/server.crt ./
cp /etc/openvpn/easy-rsa/pki/private/server.key ./
cp /etc/openvpn/easy-rsa/ta.key ./
mkdir -p /var/log/openvpn/
chown openvpn:openvpn /var/log/openvpn
cd /etc/openvpn/
mkdir -p /etc/openvpn/ccd
chown -R openvpn:nginx /etc/openvpn/client/
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
cat >/etc/openvpn/ccd/web<<eof
ifconfig-push 10.8.0.2 10.8.0.1 #表示给客户端分配一个特定ip地址
push "redirect-gateway def1 bypass-dhcp"
eof
cat >/etc/openvpn/management-pass<<eof
passwd
##密码
eof
systemctl start openvpn@server
systemctl enable openvpn@server
chown -R root:nginx /var/log/openvpn/*
chmod -R 755 /var/log/openvpn/*
echo 已经安装好了openvpn
checkiptables
exit 0
}

######安装iptables######
function installiptables(){
systemctl stop firewalld
systemctl mask firewalld

setenforce 0
sed -i 's/SELINUX=enforcing/SELINUX=disabled/g' /etc/selinux/config

yum install -y iptables-services
systemctl enable iptables
systemctl start iptables
/usr/sbin/iptables -F
NIC=$(ip -4 route ls | grep default | grep -Po '(?<=dev )(\S+)' | head -1)
PORT=$(grep '^port ' /etc/openvpn/server.conf | cut -d " " -f 2)
PROTOCOL=$(grep '^proto' /etc/openvpn/server.conf |cut -d " " -f 2)
iptables -t nat -I POSTROUTING 1 -s 10.8.0.0/24 -o $NIC -j MASQUERADE
iptables -I INPUT 1 -i tun0 -j ACCEPT
iptables -I FORWARD 1 -i $NIC -o tun0 -j ACCEPT
iptables -I FORWARD 1 -i tun0 -o $NIC -j ACCEPT
iptables -I INPUT 1 -i $NIC -p $PROTOCOL --dport $PORT -j ACCEPT
#iptables -t nat -A POSTROUTING -s 10.8.0.0/24
#iptables -t nat -A POSTROUTING -s 10.8.0.0/24 -o ens33 -j MASQUERADE
##iptables -t nat -A POSTROUTING -s 10.8.0.0/24 -o ens37 -j MASQUERADE
#i#ptables -I INPUT -p tcp --dport 53 -j ACCEPT
#iptables -I INPUT -p udp --dport 53 -j ACCEPT
#iptables -A INPUT -i ens33 -s 192.168.100.10 -j ACCEPT
iptables -L -t nat
/usr/sbin/iptables-save > /etc/sysconfig/iptables
forward=$(grep "net.ipv4.ip_forward = 1*" /etc/sysctl.conf )
if [[ $forward == "net.ipv4.ip_forward = 1" ]];then
exit 0
else
echo net.ipv4.ip_forward = 1 >> /etc/sysctl.conf
sysctl -p
fi
chown -R nginx:nginx /etc/openvpn/
systemctl restart openvpn@server
systemctl enable openvpn@server
hostnamectl set-hostname OpenVpn
##wget https://raw.githubusercontent.com/Angristan/openvpn-install/master/openvpn-install.sh -O centos7-vpn.sh
exit 0
}

######启动iptables######
function startiptables(){
systemctl start iptables
exit 0
}

######检查防火墙######
function checkiptables() {
ipstatus=$(systemctl status iptables|grep Active|awk '{print$2}')
case $ipstatus in
'active')
echo ""
echo "iptables-service正在运行";
echo ""
read -p"是否重新安装:y/n:" reinstallip
if [[ $reinstallip == "n" ]];then
exit 0
elif [ $reinstallip == "y" ];then
installiptables
else
checkiptables
fi
;;
'inactive')
echo ""
echo "iptables-service没有启动，是否启动"
echo ""
read -p"是否启动:y/n:" restartip
if [[ $restartip == "n" ]];then
exit 0
elif [ $restartip == "y" ];then
startiptables
exit 0
else
checkiptables
exit 0
fi
;;
*)
installiptables
exit 0
;;
esac

}
######检查是否安装openvpn######
function checkopenvpn(){
if [[ -e /etc/openvpn/server/certs ]];then
if [[ -e /etc/openvpn/server.conf ]];then
echo ""
echo "你已经安装好了openvpn";
echo ""
read -p"是否重新安装:y/n:" reinstall
if [[ $reinstall == "n" ]];then
checkiptables
exit 0
elif [ $reinstall == "y" ];then
installopenvpn
else
checkopenvpn
fi
fi
else
installopenvpn
fi
}
######先运行check检查是否安装openvpn######
checkopenvpn