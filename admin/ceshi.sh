PROTOCOL=$1
echo 要改为什么协议$PROTOCOL
OLDPROTO=$(grep "proto" b.txt |awk '{print$2}')
	case $OLDPROTO in
'tcp')
echo 旧的协议，默认协议
echo $OLDPROTO
echo morentcp
if [[ $PROTOCOL -eq 'udp' ]];	then
		sed  -i "s/proto tcp/proto udp/g" /root/cdshi/b.txt
		sed -i -e 's/;explicit-exit-notify/explicit-exit-notify/g' /root/cdshi/b.txt
echo 执行改为udp端口
echo 旧的协议
echo $OLDPROTO
echo "改后效果"
grep "proto" b.txt
fi
;;
'udp')
echo 旧的协议，默认协议
	echo morenudp
	echo $OLDPROTO
    if [[ $PROTOCOL -eq 'tcp' ]];	then
		sed  -i "s/proto udp/proto tcp/g" /root/cdshi/b.txt
		sed -i -e 's/explicit-exit-notify/;explicit-exit-notify/g' /root/cdshi/b.txt
echo 执行改为tcp端口
echo 旧的协议
echo $OLDPROTO
echo 改后效果
grep "proto" b.txt
fi
;;
esac