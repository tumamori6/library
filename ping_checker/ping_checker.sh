#!/bin/bash
​
IP_LIST=(160.16.139.140)
MAILTO='tumamori6@gmail.com'
LOG_FILE=./ping.log
​
for ip in ${IP_LIST[@]}
do
  ping_result=$(ping -w 5 $ip | grep '100% packet loss')
  date_result=$(date)
​
  if [[ -n $ping_result ]]; then
    echo "[SEVERE] server inactive: $ip $date_result" >> $LOG_FILE
    echo $ip | mail -s "[ALERT] server down!! $date_result" $MAILTO
  else
    echo "[INFO] server active: $ip $date_result" >> $LOG_FILE
  fi
done