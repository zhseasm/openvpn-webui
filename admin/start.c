#include <stdio.h> 
#include <stdlib.h> 
#include <sys/types.h> 
#include <unistd.h> 
int main() 
{ 
uid_t uid ,euid; 
//char cmd[1024]; 
//变量暂时未使用 
uid = getuid() ; 
euid = geteuid(); 

//printf("my uid :%u\n",getuid()); //这里显示的是当前的uid 可以注释掉. 
//printf("my euid :%u\n",geteuid()); //这里显示的是当前的euid 
if(setreuid(euid, uid)) //交换这两个id 
perror("setreuid"); 
//printf("after setreuid uid :%u\n",getuid()); 
//printf("afer sertreuid euid :%u\n",geteuid()); 
system("bash /var/www/html/admin/loginfo.sh"); //执行脚本 
return 0; 
} 
