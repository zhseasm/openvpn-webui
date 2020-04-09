#!/usr/bin/env bash


not_root() {
    echo "ERROR: You have to be root to execute this script"
    exit 1
}

: ${1?"Usage: $0 -c clientname -s server -p pass -o outdir"}



# Check if user is root
[ $EUID != 0 ] && not_root



# get working directory (where script and example configuration files are stored)
SCRIPTDIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"



while [[ $# -gt 1 ]]
do
key="$1"

case $key in
    -c|--clientname)
    CLIENTNAME="$2"
    shift # past argument
    ;;
	-s|--server)
    SERVER="$2"
    shift # past argument
    ;;
    -p|--pass)
    PASS="$2"
    shift # past argument
    ;;
    -o|--outdir)
    OUTDIRTEMP="$2"
    shift # past argument
    ;;
    --default)
    DEFAULT=YES
    ;;
    *)
            # unknown option
    ;;
esac
shift # past argument or value
done




echo CLIENT NAME	 = "${CLIENTNAME}"
echo SERVER URL     = "${SERVER}"

PORT=$(grep "port" /etc/openvpn/server.conf|awk '{print$2}')
PROTO=$(grep "proto" /etc/openvpn/server.conf)
if [[ -e /etc/openvpn/client/sample.ovpn ]];then
set -e
OVPN_USER_KEYS_DIR=/etc/openvpn/client/keys
EASY_RSA_DIR=/etc/openvpn/easy-rsa/
PKI_DIR=$EASY_RSA_DIR/pki
else
cat > /etc/openvpn/client/sample.ovpn <<eof
# 指定这是一个客户端，我们将从服务器获取某些配置文件指令
client
# 在大多数系统中，除非你部分禁用或者完全禁用了TUN/TAP接口的防火墙，否则VPN将不起作用
dev tun
# 指定连接的服务器是采用TCP还是UDP协议，这里需要使用与服务器端相同的设置
proto udp
# 指定服务器的主机名(或IP)以及端口号，如果有多个VPN服务器，为了实现负载均衡，你可以设置多个remote指令
#remote my-server-1 21198;
###这里需要服务器地址、端口
remote 192.168.1.121 1194
# 启用该指令，与服务器连接中断后将自动重新连接，这在网络不稳定的情况下(例如：笔记本电脑无线网络)非常有用
resolv-retry infinite
# 大多数客户端不需要绑定本机特定的端口号
nobind
# 持久化选项可以尽量避免访问在重启时由于用户权限降低而无法访问的某些资源
persist-key
persist-tun
remote-cert-tls server
# 启用允许数据压缩，服务端配置文件也需要有这项
comp-lzo
# 指定日志文件的记录详细级别，可选0-9，等级越高日志内容越详细
verb 3
auth-nocache
;auth-user-pass
;static-challenge "Enter Google Authenticator Token" 1
script-security 3
eof
fi

 if [ -d "$OVPN_USER_KEYS_DIR/$CLIENTNAME" ];then
 echo "用户已经存在"
 exit 0
 fi
  cd $EASY_RSA_DIR
  # 生成客户端 ssl 证书文件
  ./easyrsa build-client-full $CLIENTNAME nopass
  # 整理下生成的文件s
  mkdir -p  $OVPN_USER_KEYS_DIR/$CLIENTNAME
  cp $PKI_DIR/ca.crt $OVPN_USER_KEYS_DIR/$CLIENTNAME/   # CA 根证书
  cp $PKI_DIR/issued/$CLIENTNAME.crt $OVPN_USER_KEYS_DIR/$CLIENTNAME/   # 客户端证书
  cp $PKI_DIR/private/$CLIENTNAME.key $OVPN_USER_KEYS_DIR/$CLIENTNAME/  # 客户端证书密钥
  cp /etc/openvpn/client/sample.ovpn $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn # 客户端配置文件
  sed -i 's/admin/'"$CLIENTNAME"'/g' $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
  cp /etc/openvpn/server/certs/ta.key $OVPN_USER_KEYS_DIR/$CLIENTNAME/ta.key  # auth-tls 文件
  sed -i "s/remote 192.168.1.121 1194/remote $SERVER $PORT/g" $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
  sed -i "s/proto udp/$PROTO/g" $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn

        echo "<ca>" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
		cat "$PKI_DIR/ca.crt" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
		echo "</ca>" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn

		echo "<cert>" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
		awk '/BEGIN/,/END/' "$PKI_DIR/issued/$CLIENTNAME.crt" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
		echo "</cert>" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn

		echo "<key>" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
		cat "$PKI_DIR/private/$CLIENTNAME.key" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
		echo "</key>" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn

		echo "<tls-crypt>" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
		cat /etc/openvpn/server/certs/ta.key >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn
		echo "</tls-crypt>" >> $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.ovpn

  cd $OVPN_USER_KEYS_DIR
  zip -r $CLIENTNAME.zip $CLIENTNAME
  ####把zip移动到对应目录下
  mv $CLIENTNAME.zip $CLIENTNAME
  cp $OVPN_USER_KEYS_DIR/$CLIENTNAME/$CLIENTNAME.zip $OUTDIRTEMP

#mysql部分
 mysql --connect-expired-password -uopenvpn -popenvpn -e "insert into openvpn.vpnuser(name,password)values('$CLIENTNAME',password('$PASS'));"
#otp部分

host=$(hostname)
secret=$(/usr/bin/google-authenticator --time-based --disallow-reuse --force --rate-limit=3 --rate-time=30 --window-size=17 --issuer=foocorp --label=$CLIENTNAME@$host |grep "Your new secret key is:"|cut -d ":" -f 2|sed 's/ //g')
echo "$CLIENTNAME otp totp:sha1:base32:$secret::xxx *" >> /etc/openvpn/auth/otp-secrets
#script部分
echo "$CLIENTNAME $PASS" >> /etc/openvpn/psw-file
echo "done"


