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
    ;;
    esac
else
echo "auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
fi

static=$(grep "static-challenge" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn|cut -d " " -f 1)
if [[ $static ]];then
    case $static in
    'static-challenge')
    sed -i "s/static-challenge/;static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    esac
else
echo ';static-challenge "Enter Google Authenticator Token" 1' >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
fi
;;
	'plugin /usr/local/lib/openvpn/openvpn-otp.so')
otp=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
	if [[ $otp ]];then
	   case $otp in
	';auth-user-pass')
	sed -i "s/;auth-user-pass/auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	;;
	    esac
	    else
	    echo "auth-usere-pass" >> /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	fi

static=$(grep "static-challenge" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn|cut -d " " -f 1)
if [[ $static ]];then
    case $static in
    ';static-challenge')
    sed -i "s/;static-challenge/static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    esac
else
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
    ;;
    esac
else
echo ";auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
fi

;;
	'plugin /usr/lib64/openvpn/plugins/openvpn-plugin-auth-pam.so openvpn')
otp=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
	if [[ $otp ]];then

	   case $otp in
	';auth-user-pass')
	sed -i "s/;auth-user-pass/auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	;;
	    esac
	    else
	 echo "auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	fi

static=$(grep "static-challenge" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn|cut -d " " -f 1)
if [[ $static ]];then
    case $static in
    'static-challenge')
    sed -i "s/static-challenge/;static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    esac
else
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
	;;
	    esac
	else
	echo ";auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	fi

;;
	'auth-user-pass-verify')
otp=$(grep "auth-user-pass" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn)
	if [[ $otp ]];then

	   case $otp in
	';auth-user-pass')
	sed -i "s/;auth-user-pass/auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
	;;
	    esac
	    else
	echo "auth-user-pass" >>/etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
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
sed -i "s/auth-user-pass/;auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
sed -i "s/static-challenge/;static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    ';static-challenge')
    sed -i "s/auth-user-pass/;auth-user-pass/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    esac
;;

';auth-user-pass')
    case $staticflag in
    'static-challenge')
    sed -i "s/static-challenge/;static-challenge/g" /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    ;;
    esac
;;
esac


    else
    echo 'static-challenge "Enter Google Authenticator Token" 1' >> /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn
    fi
else
echo "auth-user-pass" >> /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn

fi

}


function changeport() {
PORT=$(grep "port" /etc/openvpn/server.conf|awk '{print$2}')
OLDPORT=$(grep "^remote " /etc/openvpn/client/keys/$CLIENTNAME/$CLIENTNAME.ovpn)
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