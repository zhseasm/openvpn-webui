#!/usr/bin/env bash
/usr/sbin/iptables -F
echo 防火墙规则清除成功
NIC=$(ip -4 route ls | grep default | grep -Po '(?<=dev )(\S+)' | head -1)
PORT=$(grep '^port ' /etc/openvpn/server.conf | cut -d " " -f 2)
PROTOCOL=$(grep '^proto' /etc/openvpn/server.conf |cut -d " " -f 2)
SUBNET=$(ip route show|grep tun0|head -n 1|awk '{print$1}')
iptables -t nat -I POSTROUTING 1 -s $SUBNET -o $NIC -j MASQUERADE
iptables -I INPUT 1 -i tun0 -j ACCEPT
iptables -I FORWARD 1 -i $NIC -o tun0 -j ACCEPT
iptables -I FORWARD 1 -i tun0 -o $NIC -j ACCEPT
iptables -I INPUT 1 -i $NIC -p $PROTOCOL --dport $PORT -j ACCEPT
#iptables-save > /etc/sysconfig/iptables
systemctl restart iptables
echo 防火墙规则已刷新
exit 0