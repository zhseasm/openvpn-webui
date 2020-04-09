#!/usr/bin/env bash
: ${1?"Usage: $0 -c clientname"}
while [[ $# -gt 1 ]]
do
key="$1"

case $key in
    -c)
    CLIENTNAME="$2"
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
cat /etc/openvpn/client/keys/$CLIENTNAME/"$CLIENTNAME".ovpn