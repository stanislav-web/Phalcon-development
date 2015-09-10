#!/bin/bash

# Define variables
export SET OSTYPE="`uname`"
export SET ENV=""
export SET PROJECT_DIR="/var/www/backend.local"
export SET DUMPFILE="build/migrations/dump.sql"
export SET DATABASE='backend.local';
export SET USER='root';
export SET PASSWORD='root';
export SET GIT_BRANCH='Rest';

# Go to  project directory
goToProject() {

    echo $FUNCNAME $1
    cd $1
}

# Setup project environment
setEnvironment() {

    case "$1" in
        production);;
        dev);;
        *) echo "Invalid input"
        exit 1
        ;;
    esac;
}

# Reboot unix web servers
rebootUnix() {
    sudo service php5-fpm restart
    sudo service nginx restart
    sudo service mysql restart
    sudo service memcached restart
}

# Pulling from remote repository
gitPull() {
    git pull origin $1
}

composerUpdate() {
    # Update composer dependencies
    if [[ "$1" == "production" ]]; then
        composer update --optimize-autoloader
    else
        composer update --profile
    fi
}

composerProductionUpdate() {
    # Update composer dependencies for production
    composer update --no-dev
    composer dump-autoload --optimize-autoloader
}

# Export MySQL dump file (if exist)
dbExport() {
    if [[ -f "$1" ]]
    then
        "mysql -u $3 -p $4 $2 < $1"
    else
    	echo "$1 file not found."
    	exit 1;
    fi
}

# Run API tests
runTests() {
    if [[ "$1" == "dev" ]]; then
        vendor/bin/codecept build
    fi
    vendor/bin/codecept run --coverage --xml --html
}

# Select environment
read -p "Please type build [production or dev]: " ENV
setEnvironment $ENV

# Detect the platform (similar to $OSTYPE)
case "$OSTYPE" in
    Linux*)
        rebootUnix
   ;;
esac

goToProject $PROJECT_DIR

gitPull $GITBRANCH

composerUpdate $ENV

#dbExport $DUMPFILE $DATABASE $USER $PASSWORD
sleep 5

read -p "Press [Enter] key to start API tests..." TEST
runTests $ENV

if [[ "$ENV" == "production" ]]; then
    composerProductionUpdate
fi