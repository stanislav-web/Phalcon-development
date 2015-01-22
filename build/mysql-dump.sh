#!/bin/sh

# Error control
set -u;
set -e;

# Define variables

export SET DATE=$(date +"%m-%d-%Y")
export SET DATABASE='phalcon.local';
export SET USER='root';
export SET PASSWORD='root';
export SET FILE=/Users/stanislavmenshykh/phalcon.local/backup/$DATABASE-$DATE.sql.gz
export SET DIR=`dirname "$FILE"`
export SET SP="/-\|"
export SET SC=0

# Create backup directory

if [[ ! -e $DIR ]]; then
            mkdir $DIR
            chmod 0777 $DIR
elif [[ ! -d $DIR ]]; then
    echo "$DIR already exists but is not a directory" 1>&2
fi


showtables() {

    # Show MySQL tables of choised database

    echo "\033[1;35m SHOW TABLES FROM $DATABASE \033[0m";
    mysql -u$USER -p$PASSWORD $DATABASE -e "USE $DATABASE; SHOW TABLE STATUS";

}

mysqlbackup() {

    # Dump tables

    mysqldump -u$USER -p$PASSWORD -R -T $DATABASE | gzip > $FILE;
}

spin() {

   # Process spinner

   printf "\b${SP:SC++:1}"
   ((SC == ${#SP})) && SC=0
}

endspin() {

    # End script
    echo "\033[0;32m MySQL backup created. \033[0m"
}

dump() {

    # Do backup process

    until mysqlbackup; do
        spin
        echo "\033[0;37m Backing up data to $FILE file, please wait... \033[0m"
            done
        endspin
}

# Show dump tables
showtables;

# Prompt dialog to confirm dump

while true; do
    read -p "Do you wish to create dump of this tables? " yn
    case $yn in
        [Yy]* ) dump; break;;
        [Nn]* ) exit;;
        * ) echo "Please answer \033[4m [y] \033[0mor \033[4m [n] \033[0m.";;
    esac
done