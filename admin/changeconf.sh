#!/usr/bin/env bash
#!/bin/bash
#

function not_root() {
    echo "ERROR: You have to be root to execute this script"
    exit 1
}

: ${1?"Usage: $0 -pr proto -po port -s subnet -m netmask -c cipher -i intraclientenable -u username -mysq mysql -ot otp -scr script -l lzoenable"}





# Check if user is root
[ $EUID != 0 ] && not_root


while [[ $# -gt 1 ]]
do
key="$1"

case $key in
    -pr)
    PROTOCOL="$2"
    shift # past argument
    ;;
	-po)
    PORT="$2"
    shift # past argument
    ;;
	-s)
    SUBNET="$2"
    shift # past argument
    ;;
	-m)
    NETMASK="$2"
    shift # past argument
    ;;
	-c)
    CIPHER="$2"
    shift # past argument
    ;;
	-i)
    INTERCLIENT="$2"
    shift # past argument
    ;;
     -u)
     USERNAME="$2"
    shift # past argument
    ;;
     -mysq)
     MYSQL="$2"
    shift # past argument
    ;;
     -ot)
     OTP="$2"
    shift # past argument
    ;;
     -scr)
     SCRIPT="$2"
    shift # past argument
    ;;
	-l)
    LZO="$2"
    shift # past argument
    ;;
    --default)
    DEFAULT=YES
    ;;
    *)
            # unknown option
    ;;
esac
shift # past argument or value
done



#change protocol entry
if [[ -n $PROTOCOL ]];then
#echo 需要改为的端口
#echo $PROTOCOL
OLDPROTO=$(grep "proto" /etc/openvpn/server.conf |awk '{print$2}')
	case $OLDPROTO in
'tcp')
#echo 旧的协议端口
#echo $OLDPROTO
#echo 默认是tcp端口
#cho morentcp
if [[ $PROTOCOL = 'udp' ]];	then
		sed  -i "s/proto tcp/proto udp/g" /etc/openvpn/server.conf
		sed -i -e 's/;explicit-exit-notify/explicit-exit-notify/g' /etc/openvpn/server.conf
#		echo gaiudp
fi
;;
'udp')
#	echo morenudp
#	echo 旧的协议端口
#	echo $OLDPROTO
    if [[ $PROTOCOL = 'tcp' ]];	then
		sed  -i "s/proto udp/proto tcp/g" /etc/openvpn/server.conf
		sed -i -e 's/explicit-exit-notify/;explicit-exit-notify/g' /etc/openvpn/server.conf
#		echo gaitcp
fi
;;
esac
fi

#change port entry
if [[ -n $PORT ]]
then
	#change protocol entry
	OLDPORT=$(cat /etc/openvpn/server.conf | grep port)
	sed -i -e 's/'"$OLDPORT"'/'"port $PORT"'/g' /etc/openvpn/server.conf
fi


#change transit net entry
if [[ -n $SUBNET ]]
then

	if [[ -n $NETMASK ]]
	then
		echo "server $SUBNET $NETMASK"
		#echo "$NEWNET"
		#exit 1
		#change protocol entry
		OLDNET=$(cat /etc/openvpn/server.conf | grep "server ")
		sed -i -e 's/'"$OLDNET"'/'"server $SUBNET $NETMASK"'/g' /etc/openvpn/server.conf
	fi
fi


#change cipher entry
if [[ -n $CIPHER ]]
then
	#change protocol entry
	OLDCIPHER=$(cat /etc/openvpn/server.conf | grep cipher)
	sed -i -e 's/'"$OLDCIPHER"'/'"cipher $CIPHER"'/g' /etc/openvpn/server.conf
fi


#change intraClientComm entry
if [[ -n $INTERCLIENT ]]
then
	#change protocol entry
	OLDINTER=$(cat /etc/openvpn/server.conf | grep client-to-client)

	if [ $INTERCLIENT -eq "1" ];	then
		sed -i -e 's/'"$OLDINTER"'/'"client-to-client"'/g' /etc/openvpn/server.conf
	else
		sed -i -e 's/'"$OLDINTER"'/'";client-to-client"'/g' /etc/openvpn/server.conf

	fi
fi


##change username
if [[ -n $USERNAME ]]
then
	#change protocol entry
	OLDUSERNAME=$(grep username /etc/openvpn/server.conf)

	if [ $USERNAME -eq "1" ];	then
		sed -i -e 's/'"$OLDUSERNAME"'/'"username-as-common-name"'/g' /etc/openvpn/server.conf
	else
		sed -i -e 's/'"$OLDUSERNAME"'/'";username-as-common-name"'/g' /etc/openvpn/server.conf

	fi
fi


##change mysql
if [[ -n $MYSQL ]]
then
	OLDMYSQL=$(grep "plugins" /etc/openvpn/server.conf)
	case $OLDMYSQL in
';plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn')
#echo $OLDMYSQL
#echo moren1
if [ $MYSQL -eq '1' ];	then
		sed  -i "s/;plugin \\/usr\\/lib64\\/openvpn\\/plugins\\/openvpn-plugin-auth-pam.so/plugin \/usr\/lib64\/openvpn\/plugins\/openvpn-plugin-auth-pam.so/g" /etc/openvpn/server.conf
#echo zhixing1
#echo $OLDMYSQL
fi
;;
	'plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn')
#	echo moren0
#	echo $OLDMYSQL
    if [ $MYSQL -eq '0' ];	then
		sed  -i "s/plugin \\/usr\\/lib64\\/openvpn\\/plugins\\/openvpn-plugin-auth-pam.so/;plugin \/usr\/lib64\/openvpn\/plugins\/openvpn-plugin-auth-pam.so/g" /etc/openvpn/server.conf
#echo zhixing0
#echo $OLDMYSQL
fi
;;
esac
fi

if [[ -n $OTP ]]
then
OLDOTP=$(grep "openvpn-otp.so" /etc/openvpn/server.conf|awk '{print$1" "$2}')
	case $OLDOTP in
';plugin /usr/local/lib/openvpn/openvpn-otp.so')
#echo $OLDOTP
#echo moren0
if [ $OTP -eq '1' ];	then
		sed  -i "s/;plugin \\/usr\\/local\\/lib\\/openvpn\\/openvpn-otp.so/plugin \/usr\/local\/lib\/openvpn\/openvpn-otp.so/g" /etc/openvpn/server.conf
#echo $OLDOTP
fi
;;
	'plugin /usr/local/lib/openvpn/openvpn-otp.so')
	#echo moren1
	#echo $OLDOTP
    if [ $OTP -eq '0' ];	then
		sed  -i "s/plugin \\/usr\\/local\\/lib\\/openvpn\\/openvpn-otp.so/;plugin \/usr\/local\/lib\/openvpn\/openvpn-otp.so/g" /etc/openvpn/server.conf
#echo zhixing0
#echo $OLDOTP
fi
;;
esac


fi

###changer shell
if [[ -n $SCRIPT ]]
then
OLDSCRIPT=$(grep "auth-user-pass-verify" /etc/openvpn/server.conf |awk '{print$1}')
	case $OLDSCRIPT in
';auth-user-pass-verify')
#echo $OLDSCRIPT
#echo moren0
if [ $SCRIPT -eq '1' ];	then
		sed  -i "s/;auth-user-pass-verify/auth-user-pass-verify/g" /etc/openvpn/server.conf
#echo zhixing1
#echo $OLDSCRIPT
fi
;;
	'auth-user-pass-verify')
#	echo moren1
#	echo $OLDSCRIPT
    if [ $SCRIPT -eq '0' ];	then
		sed  -i "s/auth-user-pass-verify/;auth-user-pass-verify/g" /etc/openvpn/server.conf
#echo zhixing0
#echo $OLDSCRIPT
fi
;;
esac

fi



#change lzo entry
if [[ -n $LZO ]]
then
	#change protocol entry
	OLDLZO=$(cat /etc/openvpn/server.conf | grep lzo)

	if [ $LZO -eq "1" ];	then
		sed -i -e 's/'"$OLDLZO"'/'"comp-lzo"'/g' /etc/openvpn/server.conf
	else
		sed -i -e 's/'"$OLDLZO"'/'";comp-lzo"'/g' /etc/openvpn/server.conf

	fi
fi



echo "Port $PORT"
echo "Proto $PROTOCOL"
echo "Transit Net $SUBNET"
echo "Transit Net Mask: $NETMASK"
echo "Cipher: $CIPHER"
echo "Client to client $INTERCLIENT"
echo "Username as Common-name $USERNAME"
echo "Mysql: $MYSQL"
echo "Otp: $OTP"
echo "Script: $SCRIPT"
echo "LZO Compression: $LZO"
sudo bash /var/www/html/admin/add-openvpn-rules.sh
sudo bash /var/www/html/admin/restart.sh
/usr/sbin/iptables-save > /etc/sysconfig/iptables
exit 0
