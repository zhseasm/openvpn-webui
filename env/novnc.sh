#!/usr/bin/env bash
: ${1?"Usage: $0 -n novnc"}
while [[ $# -gt 1 ]]
do
key="$1"

case $key in
    -n|--novnc)
    NOVNC="$2"
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

if [[ $NOVNC ]];then
nnovnc=$(grep "https://vnc.vpn.com/vnc/" /var/www/html/view/novnc.php)

if [[ $nnovnc ]];then
sed -i "s/vnc.vpn.com\/vnc\//$NOVNC:6080\/vnc.html/g" /var/www/html/view/novnc.php
fi
fi
echo done