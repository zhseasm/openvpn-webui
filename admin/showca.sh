#!/usr/bin/env bash
awk '{print NR ":" $0}' /etc/openvpn/easy-rsa/pki/index.txt | sort -t: -k 1nr,1 | sed 's/^[0-9][0-9]*://'
exit 0