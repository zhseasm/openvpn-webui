#!/usr/bin/env bash
#echo goudan
username=zzzz
host=$(hostname)
#miyao=$(/usr/bin/google-authenticator --time-based --disallow-reuse --force --rate-limit=3 --rate-time=30 --window-size=17 --issuer=foocorp --label=$username@$host |grep "Your new secret key is:"|cut -d ":" -f 2)
#echo $miyao
/usr/bin/google-authenticator --time-based --disallow-reuse --force --rate-limit=3 --rate-time=30 --window-size=17 --issuer=foocorp --label=$username@$host