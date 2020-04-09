#!/usr/bin/env bash
logerror=$(systemctl status openvpn@server -l|grep error|grep -v '^$')
if [[ $logerror ]];then
{
echo $logerror
}
else
{
tail -n 4 /var/log/openvpn/server.log
}
fi
exit 0
