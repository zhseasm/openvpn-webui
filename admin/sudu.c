#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

#define WAIT_SECOND 	1 //暂停时间，单位为“秒”

long int getCurrentDownloadRates(long int * save_rate); //获取当前的流量，参数为将获取到的流量保存的位置

int main(int argc, char * argv[])
{
	long int start;	//保存开始时的流量计数
	long int end;	//保存结果时的流量计数
	while(1)
		{
			getCurrentDownloadRates(&start);

			sleep(WAIT_SECOND);

			getCurrentDownloadRates(&end);

			printf("download is :[%ld] - [%ld] = %.2lf Bytes/s\n", end,  start, (float)(end-start)/WAIT_SECOND );//打印结果
		}
	exit(EXIT_SUCCESS);
}



long int getCurrentDownloadRates(long int * save_rate)
{
	FILE * net_dev_file;	//文件指针
	char buffer[1024];	//文件中的内容暂存在字符缓冲区里
	size_t bytes_read;	//实际读取的内容大小
	char * match;	 //用以保存所匹配字符串及之后的内容

	net_dev_file=fopen("/proc/net/dev", "r");
	if ( net_dev_file == NULL )
		{
			printf("open file /proc/net/dev/ error!\n");
			exit(EXIT_FAILURE);
		}

	bytes_read = fread(buffer, 1, sizeof(buffer), net_dev_file);//将文件中的1024个字符大小的数据保存到buffer里
	fclose(net_dev_file); //关闭文件


	if ( bytes_read == 0 )//如果文件内容大小为０，没有数据则退出
		{
			exit(EXIT_FAILURE);
		}


	buffer[bytes_read] = '\0';
	match = strstr(buffer, "ens33:");//匹配ppp0第一次出现的位置，返回值为第一次出现的位置的地址
	if ( match == NULL )
		{
			printf("no ppp0 keyword to find!\n");
			exit(EXIT_FAILURE);
		}
	sscanf(match, "ppp0:%ld", save_rate);//从字符缓冲里读取数据，这个值就是当前的流量啦。呵呵。
	return *save_rate;
}



