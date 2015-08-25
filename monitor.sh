#!/bin/bash -e
while true
do
rm ./monitor_log/vmstat.log
vmstat -S m > ./monitor_log/vmstat.log

#TODAY=`date +"%Y%m%d"`
HTTPD=`ps aux | grep httpd | grep -v grep | wc -l`
DB=`ps aux | grep postgres | grep -v grep | wc -l`
DISK=`df -h | awk NR==2 | awk '{print $3}' | sed 's/G//g'`
READ=`tail -n 1 ./monitor_log/vmstat.log | awk '{print $1}'`
WRITE=`tail -n 1 ./monitor_log/vmstat.log | awk '{print $2}'`
FREEMEM=`tail -n 1 ./monitor_log/vmstat.log | awk '{print $4+$5+$6}'`
CPU=`tail -n 1 ./monitor_log/vmstat.log | awk '{print $13+$14}'`

echo $HTTPD,$DB,$DISK,$READ,$WRITE,$FREEMEM,$CPU,`date +"%d %k:%M:%S"` >> ./monitor_log/monitor_`date +%Y%m`.csv
#sed '/,,,/d' monitor_`date +%Y%m%d`.csv > monitor_`date +%Y%m%d`.csv
#sed -e "3,5d" vmstat.log
sleep 240
done
