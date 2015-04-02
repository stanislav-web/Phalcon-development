#!/bin/bash
# Error control

set -u;
set -e;

# Define variables
OSTYPE="`uname`"

# Detect the platform (similar to $OSTYPE)

case "$OSTYPE" in
    Linux*)

        sudo service php5-fpm restart
        sudo service nginx restart
        sudo service mysql restart
        sudo service memcached restart
   ;;
esac

cd ../
read -p "Please type pulled GIT Branch: " GIT_BRANCH
git pull origin $GIT_BRANCH

read -p "Press [Enter] key to update dependencies..." DEP
composer update

#read -p "Press [Enter] key to start API tests" TEST
vendor/bin/codecept build
vendor/bin/codecept run -d
