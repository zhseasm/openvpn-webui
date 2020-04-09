#!/usr/bin/env bash
for user in $@
do
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
done