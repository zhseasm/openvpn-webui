mkdir -p /var/log/openvpn/
chown openvpn:openvpn /var/log/openvpn
systemctl start openvpn@server
systemctl enable openvpn@server
chown -R root:nginx /var/log/openvpn/*
chmod -R 755 /var/log/openvpn/*
