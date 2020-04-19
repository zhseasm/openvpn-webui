#!/usr/bin/env bash
yum install -y epel-release
###novnc x11vnc
yum install -y novnc x11vnc
yum groupinstall -y "X window System"
yum groupinstall -y "GNOME Desktop" "Graphical Administration Tools"
#startx
systemctl set-default graphical.target
cat > /etc/systemd/system/x11vnc.service<<eof
[unit]
Description=Start x11vnc at startup.
After=multi-user.target

[Service]
Type=simple
Restart=on-failure
RestartSec=5s
ExecStart=/usr/bin/x11vnc -auth guess -once -loop -noxdamage -repeat -rfbauth /root/.vnc/passwd -rfbport 5900 -shared

[Install]
WantedBy=multi-user.target
eof

##vncpasswd
x11vnc --storepasswd

###novnc
#host=`hostname`
#echo $host|openssl req -new -x509 -days 365 -nodes -out /usr/share/novnc/self.pem -keyout self.pem

cat >/usr/share/novnc/self.pem<<eof
-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDPnKDnWS0/sBUy
Lw47DmfOwXm/ddjm1qd88nurgyeMpt4TNbK68d5btRfaiDKCoMilpfqB1J1rV809
K6r3R3TrR6nBdFIUo8KxauvDOlUPvTPhElWW+FFbuU9pPpMEEsDmpe3VBNbqUGcd
CRJyOqAGD5k2ChsdX1zU+gyOskAeevu3yeCWSqZ7/P5AkF8RnwnaKAy5eNLHHi+o
Lv6mve7TwTeQkb+jSpsJ8LHZsihyUIa2iNpK3sA28ZhtSzD/P6PVQUM3fikYEcs6
mHmKdk55OfHXMcJsbfB1Wvz9XgW/ltj2JKzQQ/DT88LwdkSEh1O86LOYE5KLEAhi
xhelg8JXAgMBAAECggEACDbZQu4LVUbBP/AOrxV90/dhusqN32xEyjPJ4tpYmT8M
8FOik7T4KEa8/999qB92cN9lTve7lsCtlSsCI7CHFrwKImZYzQpBrMVfOKU5Mls5
D0Grc0K17VwioTZhmLqpOTb9dv0vB6xQuBxgx3Y8WKELXdD+i6X3RVHzZz30PYBr
8NxRxUPA4vKcXABN7BbdCOyMnoGT28GgPgEKGHXWi+ui5/MZznOdeTxC7PahOZ0F
bz9ypeaHX1FH4ZU6X4GBOnt1cg8k7+8T4F9AAog23HbOFDq1KG7B5u+bf5MhBFs8
tWuXEA9j6eHCq+ETfS7r/BZqeRwyv2O4meCgU7ij6QKBgQDoI738OTOxTHSDmoA5
8pzPOka4sF5X5ZwLXnyHG2cINtcpJzWt1rYeLF7u/vqJddiv+pbsLg/3dgcVFExd
BX0UxyP8pUHGGVfeBOWFesZTzpa61g38uIRZmyfQqluAs383CnpLbnu/kBdgopE/
drKM1POiYS6bP+lrRZnV9Pju5QKBgQDk8313A8nWNvy/5RWVI0Zv9VIFcXBWOFcy
DCmFtjGUyrSpdFFVE59BpNPLOVeKbUoGS08KUGy4k9T4jOpMDemVFCroPEjs6M6t
lb+NgUzqtFiF+6HPEWplOQbNO1ohlLSzhyGxrowR8Q+RoVgZdwiw45LgfWsNQHEn
XzLzKsUciwKBgQCc1Kjh4fNecPy2fIbsn0/5YLGuzNiwIVuPAsK2tHijQAmUr/y/
+TMIp4lrha/VdlxyZ6XW4je/Q2n9f70nizG5++AAK9WH9E88m6pEx3F95TBIAZ1p
g29G6l+3xaAUDzB/CwEcPQQ1oy9oBeyDJ7nxE12V8nn+QOt9oYQQ3HPhUQKBgQDh
JnZu0QHvMHoUODOmS19cgJLdmXYQxC0zoXQ/8zEFEubhcer90GMgCfjh9I0bK2jN
kcez6+1PAspAd0t96XyYx5F+erJ4kGWXnRkYDlzWvu4DLLcuTAEmdBM1RrXXKkcd
+bjv5CgJCNf3rgRWXpHkapgpPg1FpebhAiS3r4rSCwKBgHih8UMHp0U1HxgMTfJz
e9t9RHX76bfZpc3GIQHQ2+dIKR1Uf+ZLJp87r//w/ThMGgisjeKwrGZ2qKabpvMt
TTLSkq8fyymhBghTUdm83zM3Sc2GScT0XDrFeSTwR5merqo0qoQ2vDRlesZit0WY
eHn7fhIG55js8nQpc7tj1YcS
-----END PRIVATE KEY-----
-----BEGIN CERTIFICATE-----
MIIDVzCCAj+gAwIBAgIJAOV/OsHDNQBwMA0GCSqGSIb3DQEBCwUAMEIxCzAJBgNV
BAYTAlhYMRUwEwYDVQQHDAxEZWZhdWx0IENpdHkxHDAaBgNVBAoME0RlZmF1bHQg
Q29tcGFueSBMdGQwHhcNMjAwNDAyMTc1MzUxWhcNMjEwNDAyMTc1MzUxWjBCMQsw
CQYDVQQGEwJYWDEVMBMGA1UEBwwMRGVmYXVsdCBDaXR5MRwwGgYDVQQKDBNEZWZh
dWx0IENvbXBhbnkgTHRkMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA
z5yg51ktP7AVMi8OOw5nzsF5v3XY5tanfPJ7q4MnjKbeEzWyuvHeW7UX2ogygqDI
paX6gdSda1fNPSuq90d060epwXRSFKPCsWrrwzpVD70z4RJVlvhRW7lPaT6TBBLA
5qXt1QTW6lBnHQkScjqgBg+ZNgobHV9c1PoMjrJAHnr7t8nglkqme/z+QJBfEZ8J
2igMuXjSxx4vqC7+pr3u08E3kJG/o0qbCfCx2bIoclCGtojaSt7ANvGYbUsw/z+j
1UFDN34pGBHLOph5inZOeTnx1zHCbG3wdVr8/V4Fv5bY9iSs0EPw0/PC8HZEhIdT
vOizmBOSixAIYsYXpYPCVwIDAQABo1AwTjAdBgNVHQ4EFgQUEBaO8Au1iBmNYGLD
hqzxUO8y8PMwHwYDVR0jBBgwFoAUEBaO8Au1iBmNYGLDhqzxUO8y8PMwDAYDVR0T
BAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAHwPqaE6cahjMuCyCMh5OQXm5RaCo
RbEvTJQAItcTZJUnIRx+76p1hKpuCGlcN5eBgrpsIjgxe3Gi/50WvP5caop5DEKP
3NFCkp0LMfvAmRrA8BM0iNTP1Q4FoEniLHVsQ+PanNZ91I8WI05L4VR88o42BeHY
gjDelBXmidDt5ni4meVo8VLRdeyf9tyS0687VPLoQCAKzviZHWf8FUhXZv3Egx05
/E8gf9ExNqjpJ3pV06SOwjW1TUaoP5AB6QF7PFvSiObqLLI/S3BL9hUw0I4d2Fk5
KNpLQJ3PxWpD3M3GUcf081/4OtZC43UzEH+wtEXP8qYXPzH0XoPJvZGT6Q==
-----END CERTIFICATE-----
eof



cat > /etc/systemd/system/novnc.service<<eof
[unit]
Description=Start novnc at startup.
After=multi-user.target

[Service]
Type=simple
Restart=on-failure
RestartSec=5s
ExecStart=/usr/bin/novnc_server --cert /usr/share/novnc/self.pem

[Install]
WantedBy=multi-user.target
eof

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


echo gateonedone

fi
##自启
systemctl restart gateone
systemctl restart x11vnc
systemctl restart novnc
systemctl enable gateone
systemctl enable x11vnc
systemctl enable novnc
/usr/sbin/iptables-save > /etc/sysconfig/iptables
reboot
https://192.168.31.135:6080/vnc.html?host=192.168.31.135&port=6080
