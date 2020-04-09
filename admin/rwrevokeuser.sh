#!/usr/bin/env bash

not_root() {
    echo "ERROR: You have to be root to execute this script"
    exit 1
}

: ${1?"Usage: $0 -c name -o outdir"}

# Check if user is root
[ $EUID != 0 ] && not_root


while [[ $# -gt 1 ]]
do
key="$1"

case $key in
    -c|--clientname)
    CLIENTNAME="$2"
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

set -e
OVPN_USER_KEYS_DIR=/etc/openvpn/client/keys
#EASY_RSA_VERSION=
EASY_RSA_DIR=/etc/openvpn/easy-rsa/

  #cd $EASY_RSA_DIR/$EASY_RSA_VERSION
  cd $EASY_RSA_DIR
  echo -e 'yes\n' | ./easyrsa revoke $CLIENTNAME
  ./easyrsa gen-crl
  source ./vars
  # 吊销掉证书后清理客户端相关文件
  if [ -d "$OVPN_USER_KEYS_DIR/$CLIENTNAME" ]; then
    sudo rm -rf $OVPN_USER_KEYS_DIR/${CLIENTNAME}
  fi

#mysql部分
 mysql --connect-expired-password -uopenvpn -popenvpn -e "DELETE FROM openvpn.vpnuser WHERE name = '$CLIENTNAME';"
#otp部分
sed -i "/$CLIENTNAME/d" /etc/openvpn/auth/otp-secrets
#script部分
sed -i "/$CLIENTNAME/d" /etc/openvpn/psw-file

 if [ -e "$OUTDIRTEMP/$CLIENTNAME.zip" ];then
sudo  rm -rf OUTDIRTEMP/$CLIENTNAME.zip
 fi
systemctl restart openvpn@server
echo done
#安装centos7文档
#https://www.cyberciti.biz/faq/centos-7-0-set-up-openvpn-server-in-5-minutes/
#http://www.eryajf.net/3807.html#toc-1
#用户名密码验证参考文档
#https://xu3352.github.io/linux/2017/06/08/openvpn-use-username-and-password-authentication
#mysql验证参考文档
#http://www.voidcn.com/article/p-txyqemxe-bny.html
#自动吊销证书ll

#https://garywu520.github.io/blog/2018/09/12/%E5%9F%BA%E4%BA%8Eeasyrsa3%E8%87%AA%E5%8A%A8%E5%8C%96%E5%AE%9E%E7%8E%B0openvpn%E7%94%A8%E6%88%B7%E8%AF%81%E4%B9%A6%E7%9A%84%E5%88%9B%E5%BB%BA%E4%B8%8E%E5%90%8A%E9%94%80/
exit 0
