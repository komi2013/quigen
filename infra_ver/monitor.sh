#!/bin/bash -e
while true
do

rm ../monitor_log/vmstat.log
vmstat -S m > ../monitor_log/vmstat.log

HTTPD=`ps aux | grep httpd | grep -v grep | wc -l`
DB=`ps aux | grep postgres | grep -v grep | wc -l`
DISK=`df -h | awk NR==2 | awk '{print $3}' | sed 's/G//g'`
READ=`tail -n 1 ../monitor_log/vmstat.log | awk '{print $1}'`
WRITE=`tail -n 1 ../monitor_log/vmstat.log | awk '{print $2}'`
FREEMEM=`tail -n 1 ../monitor_log/vmstat.log | awk '{print $4+$5+$6}'`
USEDMEM=`expr 2000 - $FREEMEM`
CPU=`tail -n 1 ../monitor_log/vmstat.log | awk '{print $13+$14}'`

echo $HTTPD,$DB,$DISK,$READ,$WRITE,$USEDMEM,$CPU,`date +"%d %k:%M:%S"` >> ../monitor_log/monitor_`date +%Y%m`.csv

sleep 240

done