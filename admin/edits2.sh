#!/usr/bin/env bash
not_root() {
    echo "ERROR: You have to be root to execute this script"
    exit 1
}

: ${1?"Usage: $0 -c name -s subnet -n netmask -o folder"}






# Check if user is root
[ $EUID != 0 ] && not_root


while [[ $# -gt 1 ]]
do
key="$1"

case $key in
    -c|--clientname)
    CLIENTNAME="$2"
    shift # past argument
    ;;
	-n|--netmask)
    NETMASK="$2"
    shift # past argument
    ;;
	-s|--subnet)
    SUBNET="$2"
    shift # past argument
    ;;
	-o|--outdir)
    OUTDIR="$2"
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
OLDSUBONE=$(grep "ifconfig-push" /etc/openvpn/ccd/$CLIENTNAME|awk '{print$2}')
OLDSUBTWO=$(grep "ifconfig-push" /etc/openvpn/ccd/$CLIENTNAME|awk '{print$3}')
sed -i "s/$OLDSUBONE $OLDSUBTWO/$NETMASK $SUBNET/g" /etc/openvpn/ccd/$CLIENTNAME
echo done