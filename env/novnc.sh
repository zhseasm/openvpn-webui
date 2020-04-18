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
nnovnc=$(grep "https://127.0.0.1" /var/www/html/view/novnc.php)

if [[ $nnovnc ]];then
sed -i "s/127.0.0.1/$NOVNC:6080\/vnc.html/g" /var/www/html/view/novnc.php
fi
fi
echo done