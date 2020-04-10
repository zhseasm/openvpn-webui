#!/usr/bin/env bash
#客户下载配置文件地址,同时更新自己的配置文件
: ${1?"Usage: $0 -c clientname -s server"}
while [[ $# -gt 1 ]]
do
key="$1"

case $key in
    -c)
    CLIENTNAME="$2"
    shift # past argument
    ;;
     -s)
    SERVER="$2"
    shift # past argument
    ;;
--default)
    DEFAULT=YES
    ;;
    *)
;;
esac
shift
done



function changeotp() {
###otp###
OLDOTP=$(grep "openvpn-otp.so" /etc/openvpn/server.conf|awk '{print$1" "$2}')
	case $OLDOTP in
';plugin /usr/local/lib/openvpn/openvpn-otp.so')
otp=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
if [[ $otp ]];then
    case $otp in
    'auth-user-pass')
    sed -i "s/auth-user-pass/;auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
echo 1
    ;;
    esac
else
echo 2
echo ";auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
fi

static=$(grep "static-challenge" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn|cut -d " " -f 1)
if [[ $static ]];then
    case $static in
    'static-challenge')
    sed -i "s/static-challenge/;static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
   
echo 3 
 ;;
    esac
else
echo 4
echo ';static-challenge "Enter Google Authenticator Token" 1' >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
fi
;;
	'plugin /usr/local/lib/openvpn/openvpn-otp.so')
otp=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
	if [[ $otp ]];then
	   case $otp in
	';auth-user-pass')
	sed -i "s/;auth-user-pass/auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
echo 5
	;;
	    esac
	    else
echo 6
	    echo "auth-user-pass" >> /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	fi

static=$(grep "static-challenge" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn|cut -d " " -f 1)
if [[ $static ]];then
    case $static in
    ';static-challenge')
echo 7    
sed -i "s/;static-challenge/static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    esac
else
echo 8
echo 'static-challenge "Enter Google Authenticator Token" 1' >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
fi

;;
esac
}

function changemysql() {
   ##mysql###

	OLDMYSQL=$(grep "plugins" /etc/openvpn/server.conf)
	case $OLDMYSQL in
';plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn')
otp=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
if [[ $otp ]];then
    case $otp in
    'auth-user-pass')
    sed -i "s/auth-user-pass/;auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
echo 9 
   ;;
    esac
else
echo 10
echo ";auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
fi

;;
	'plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn')
otp=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
	if [[ $otp ]];then

	   case $otp in
	';auth-user-pass')
	sed -i "s/;auth-user-pass/auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
echo 11
	;;
	    esac
	    else
echo 12
	 echo "auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	fi

static=$(grep "static-challenge" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn|cut -d " " -f 1)
if [[ $static ]];then
    case $static in
    'static-challenge')
echo 13
    sed -i "s/static-challenge/;static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    esac
else
echo 14
echo ';static-challenge "Enter Google Authenticator Token" 1' >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
fi
;;
esac

}

function changescript() {
###script###

OLDSCRIPT=$(grep "auth-user-pass-verify" /etc/openvpn/server.conf |awk '{print$1}')
	case $OLDSCRIPT in
';auth-user-pass-verify')
otp=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
	if [[ $otp ]];then

	   case $otp in
	'auth-user-pass')
	sed -i "s/;auth-user-pass/auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
echo 15
	;;
	    esac
	else
echo 16
	echo ";auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	fi

;;
	'auth-user-pass-verify')
otp=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
	if [[ $otp ]];then

	   case $otp in
	';auth-user-pass')
	sed -i "s/;auth-user-pass/auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
echo 17
	;;
	    esac
	    else
echo 18
	echo "auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	fi

static=$(grep "static-challenge" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn|cut -d " " -f 1)
if [[ $static ]];then
    case $static in
    'static-challenge')
echo 19
    sed -i "s/static-challenge/;static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    esac
else
echo 20
echo ';static-challenge "Enter Google Authenticator Token" 1' >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
fi



;;
esac
}

function changeclient() {

authflag=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
staticflag=$(grep "static-challenge" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn|cut -d " " -f 1)





if [[ $authflag ]];then
    if [[ $staticflag ]];then

case $authflag in
'auth-user-pass')
    case $staticflag in
    'static-challenge')
echo 21
sed -i "s/auth-user-pass/;auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
sed -i "s/static-challenge/;static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    ';static-challenge')
echo 22
sed -i "s/auth-user-pass/;auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    esac
;;

';auth-user-pass')
    case $staticflag in
    'static-challenge')
echo 23
sed -i "s/static-challenge/;static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    esac
;;
esac


    else
echo 24
    echo 'static-challenge "Enter Google Authenticator Token" 1' >> /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    fi
else
echo 25
echo "auth-user-pass" >> /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn

fi

}


function changeport() {
PORT=$(grep "port" /etc/openvpn/server.conf|awk '{print$2}')
OLDPORT=$(grep "^remote " /etc/openvpn/client/keys/$CLIENTNAME/$CLIENTNAME.ovpn)
echo 26
sed -i "s/$OLDPORT/remote $SERVER $PORT/g" /etc/openvpn/client/keys/$CLIENTNAME/$CLIENTNAME.ovpn
}


function createzip() {
    rm -rf /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".zip
cd /etc/openvpn/client/keys/
zip -r $CLIENTNAME.zip $CLIENTNAME
mv $CLIENTNAME.zip $CLIENTNAME
cp /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".zip /var/www/html/download/
}

function checkservice() {
OLDOTP=$(grep "openvpn-otp.so" /etc/openvpn/server.conf|awk '{print$1" "$2}')
OLDMYSQL=$(grep "plugins" /etc/openvpn/server.conf)
OLDSCRIPT=$(grep "auth-user-pass-verify" /etc/openvpn/server.conf |awk '{print$1}')

case $OLDOTP in
'plugin /usr/local/lib/openvpn/openvpn-otp.so')
    case $OLDMYSQL in
        ';plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn')
            case $OLDSCRIPT in
            ';auth-user-pass-verify')
echo 27
changeotp
            ;;
            esac
        ;;
    esac
;;
esac

case $OLDMYSQL in
'plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn')
        case $OLDOTP in
        ';plugin /usr/local/lib/openvpn/openvpn-otp.so')
            case $OLDSCRIPT in
            ';auth-user-pass-verify')
echo 28
     changemysql
            ;;
            esac
        ;;
        esac
;;
esac

case $OLDSCRIPT in
'auth-user-pass-verify')
    case $OLDMYSQL in 
    ';plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn')
        case $OLDOTP in
        ';plugin /usr/local/lib/openvpn/openvpn-otp.so')
 changescript
 echo 29
        ;;
        esac
    ;;
    esac
;;
esac

case $OLDOTP in
';plugin /usr/local/lib/openvpn/openvpn-otp.so')
    case  $OLDMYSQL in
    ';plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn')
        case $OLDSCRIPT in
        ';auth-user-pass-verify')
echo 30
 changeclient
        ;;
        esac
    ;;
    esac
;;
esac

}
checkservice
changeport
createzip
echo done
