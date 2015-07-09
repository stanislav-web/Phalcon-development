#!/bin/bash

# Define variables
export SET URL="http://api.phalcon.local/api/v1/items?limit=100"
export SET LOGFILE="/var/www/phalcon.local/logs/ab.log"

# Start test

start() {
    ab -k -n $1 -c $2 -H 'Accept-Language:ru-RU' $3 > $4 &
}

# Request wishes
read -p "Type please how much requests do you wish?: " REQUESTS
read -p "How many users can perform simultaneous downloads?: " CONCURENCY
read -p "Press [Enter] to start load testing" START

start $REQUESTS $CONCURENCY $URL $LOGFILE