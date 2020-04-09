#!/usr/bin/env bash
status=$(systemctl status openvpn@server |grep Active |awk '{print$2}')
#if [ $status == 'inactive' ];then
#echo "dead";
#else
#echo 'running';
#fi
#exit 0
echo $status
exit 0
