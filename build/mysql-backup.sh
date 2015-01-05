#!/bin/bash

#Define variables

DATE=$(date +"%m-%d-%Y")
FILE=/var/www/phalcon-devtools/phalcon.local/backup/phalcon.local-$DATE.sql.gz
DIR=`dirname "$FILE"`
SUBJECT="MySQL Backup report"
EMAIL="stanisov@gmail.com"
SP="/-\|"
SC=0

# Create backup directory

if [[ ! -e $DIR ]]; then
            mkdir $DIR
            chmod 0777 $DIR
elif [[ ! -d $DIR ]]; then
    echo "$DIR already exists but is not a directory" 1>&2
fi

# Create executable functions

mysqlbackup() {
    mysqldump -u root -proot phalcon.local | gzip > $FILE;
}

spin() {
   printf "\b${SP:SC++:1}"
   ((SC == ${#SP})) && SC=0
}

endspin() {
      echo "MySQL backup created."
}

# Create spinner

until mysqlbackup; do
   spin
   echo "Backing up data to $FILE file, please wait..."
done
endspin