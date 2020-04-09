#!/usr/bin/env bash
PROTOCOL=$1
OLDPROTOCOL=$(cat /etc/openvpn/client/sample.ovpn | grep proto)

PORT=$2
OLDPORT=$(grep remote b.txt |head -1)
echo $PORT
ADDRESS=$(grep remote b.txt |head -1|awk '{print$2}')
sed -i -e 's/'"$OLDPORT"'/'"remote $ADDRESS $PORT"/'g' /etc/openvpn/client/sample.ovpn

if [[ -e /etc/openvpn/client/sample.ovpn ]];then

sed -i -e 's/'"$OLDPROTOCOL"'/'"proto $PROTOCOL"/'g' /etc/openvpn/client/sample.ovpn

