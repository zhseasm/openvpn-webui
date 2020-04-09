#!/usr/bin/env bash
cat /etc/named.conf|grep zone
cat /etc/named.conf|grep 'file "named'|grep -v 'ca'|awk '{print$2}'|cut -d ";" -f 1|xargs -t -I {} cat /var/named/{}