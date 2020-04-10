gateone --new_api_key
apikeys=$(cat -n /etc/gateone/conf.d/30api_keys.conf|grep "api"|awk '{print$1}')
apikeys=$(($apikeys+1))
api=$(sed -n "$apikeysm$apikeys p" /etc/gateone/conf.d/30api_keys.conf |cut -d ":" -f 1)
sed -i "s/$api/\"ODA4ZmNlNWFlZTBmNDM1ZmFkOGNlOWM3MTBlY2FiMGU4N\"/g" /etc/gateone/conf.d/30api_keys.conf
secret=$(sed -n "$apikeysm$apikeys p" /etc/gateone/conf.d/30api_keys.conf |cut -d ":" -f 2)
sed -i "s/$secret/\"YzZhOTljMjczNjIzNDAyOThmZDliMjQ3M2QxM2Y1NDgyM\"/g" /etc/gateone/conf.d/30api_keys.conf
