#!/usr/bin/env bash
#换python源
yum install python2-pip.noarch -y
pip install pip -U
pip config set global.index-url https://pypi.tuna.tsinghua.edu.cn/simple
#gateone
pip install -i https://pypi.tuna.tsinghua.edu.cn/simple --upgrade pip
pip install -i https://pypi.tuna.tsinghua.edu.cn/simple tornado==4.0
pip install -i https://pypi.tuna.tsinghua.edu.cn/simple gateone
pip install -i https://pypi.tuna.tsinghua.edu.cn/simple numpy
systemctl start gateone
status=$(grep "\"ODA4ZmNlNWFlZTBmNDM1ZmFkOGNlOWM3MTBlY2FiMGU4N\":\"YzZhOTljMjczNjIzNDAyOThmZDliMjQ3M2QxM2Y1NDgyM\"" /etc/gateone/conf.d/30api_keys.conf)
if [[ ! $status ]];then
gateone --new_api_key
apikeys=$(cat -n /etc/gateone/conf.d/30api_keys.conf|grep "api"|awk '{print$1}')
apikeys=$(($apikeys+1))
api=$(sed -n "$apikeysm$apikeys p" /etc/gateone/conf.d/30api_keys.conf |cut -d ":" -f 1)
sed -i "s/$api/\"ODA4ZmNlNWFlZTBmNDM1ZmFkOGNlOWM3MTBlY2FiMGU4N\"/g" /etc/gateone/conf.d/30api_keys.conf
secret=$(sed -n "$apikeysm$apikeys p" /etc/gateone/conf.d/30api_keys.conf |cut -d ":" -f 2)
sed -i "s/$secret/\"YzZhOTljMjczNjIzNDAyOThmZDliMjQ3M2QxM2Y1NDgyM\"/g" /etc/gateone/conf.d/30api_keys.conf
sed -i  "s/\"auth\": \"none\",/\"auth\":\"api\",/g" /etc/gateone/conf.d/20authentication.conf
###gateone换8443端口
sed  -i "s/\"port\": 443/\"port\": 8443/g" /etc/gateone/conf.d/10server.conf

###sshkey
host=$(hostname)
ssh-keygen -f ~/.ssh/$host
ssh-copy-id -f -i ~/.ssh/$host root@localhost
sed -i "s/users/$host/g" /etc/gateone/conf.d/10server.conf
mkdir -p /var/lib/gateone/$host/$host/.ssh
cp ~/.ssh/* /var/lib/gateone/$host/$host/.ssh/
cd /var/lib/gateone/$host/$host/.ssh/
echo "$host" > /var/lib/gateone/$host/$host/.ssh/.default_ids
#cat /var/lib/gateone/$host/$host/.ssh/$host > .default_ids
#mkdir -p /var/lib/gateone/users/$host/.ssh/
#cp ~/.ssh/*  /var/lib/gateone/users/$host/.ssh/
#cd /var/lib/gateone/users/$host/.ssh/
#cat /var/lib/gateone/users/$host/.ssh/$host > .default_ids
fi