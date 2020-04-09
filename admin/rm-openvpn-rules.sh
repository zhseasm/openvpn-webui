#!/usr/bin/env bash
/usr/sbin/iptables -F
echo 防火墙规则清除成功
NIC=$(ip -4 route ls | grep default | grep -Po '(?<=dev )(\S+)' | head -1)
PORT=$(grep '^port ' /etc/openvpn/server.conf | cut -d " " -f 2)
PROTOCOL=$(grep '^proto' /etc/openvpn/server.conf |cut -d " " -f 2)
SUBNET=$(ip route show|grep tun0|head -n 1|awk '{print$1}')
iptables -t nat -D POSTROUTING -s $SUBNET -o $NIC -j MASQUERADE
iptables -D INPUT -i tun0 -j ACCEPT
iptables -D FORWARD -i $NIC -o tun0 -j ACCEPT
iptables -D FORWARD -i tun0 -o $NIC -j ACCEPT
iptables -D INPUT -i $NIC -p $PROTOCOL --dport $PORT -j ACCEPT
iptables-save > /etc/sysconfig/iptables
systemctl restart iptables
echo 防火墙规则已刷新
exit 0