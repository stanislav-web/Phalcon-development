#!/bin/bash

# Define variables
export SET OSTYPE="`uname`"
export SET ENV=""
export SET DUMPFILE="migrations/dump.sql"
export SET DATABASE='backend.local';
export SET USER='root';
export SET PASSWORD='root';
export SET INI_PATH='/etc/php5/fpm/php.ini';

checkTool() {
    # PHP Setup checking...
    ../vendor/bin/iniscan scan --path=$1 --context=$3 --fail-only
    ../vendor/bin/iniscan scan --path=$1 --format=html --output=$2 --context=$3
    composer
}

rebootUnix() {
    # Reboot unix web servers
    sudo service php5-fpm restart
    sudo service nginx restart
    sudo service mysql restart
    sudo service memcached restart
};

gitPull() {
    # Pulling from remote repository
    git pull origin $1
};

composerUpdate() {
    # Update composer dependencies
    if [ "$1" == "production" ]; then
        composer update --optimize-autoloader
    else
        composer update --profile
    fi
};

composerProductionUpdate() {
    # Update composer dependencies for peoduction
    composer update --no-dev
    composer dump-autoload --optimize-autoloader
};

dbExport() {
    # Export MySQL dump file (if exist)
    if [ -f "$1" ]
    then
        "mysql -u $3 -p $4 $2 < $1"
    else
    	echo "$1 file not found."
    	exit 1;
    fi
};

runTests() {
    # Run API tests
    if [ "$1" == "dev" ]; then
        vendor/bin/codecept build
    fi
    vendor/bin/codecept run --coverage --xml --html
};

# Select environment
read -p "Please type build [production or dev]: " ENV

case "$ENV" in
    production);;
    dev);;
    *) echo "Invalid input"
    exit 1
    ;;
esac;

# Checking php configurations
checkTool $INI_PATH $INI_SCAN_REPORT_DIR $ENV

read -p "Press [Enter] key to reboot servers" REBOOT

# Detect the platform (similar to $OSTYPE)

case "$OSTYPE" in
    Linux*)
        rebootUnix
   ;;
esac

cd ../

read -p "Please type pulled GIT Branch: " GIT_BRANCH
gitPull $GIT_BRANCH

read -p "Press [Enter] key to update dependencies..." DEP
composerUpdate $ENV

dbExport $DUMPFILE $DATABASE $USER $PASSWORD
sleep 5

read -p "Press [Enter] key to start API tests..." TEST
runTests $ENV

# Select environment
read -p "Do you wish to prepare dependencies for production [yes or no]: " ANSWER
case "ANSWER" in
    yes*)
        composerProductionUpdate
    ;;
    *)
    exit 1
    ;;
esac;
