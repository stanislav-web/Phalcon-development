#!/bin/bash
# Error control

set -u;
set -e;

# Define variables
OSTYPE="`uname`"
ENV=""


# Select environment

read -p "Please type build [production or development]: " ENV

case "$ENV" in
    production) ;;
    development);;
    *) echo "Invalid input"
    exit 1
    ;;
esac;

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

if [ "$ENV" == "production" ]; then
composer update --optimize-autoloader
else
    composer update --profile
fi

sleep 5

read -p "Press [Enter] key to start API tests..." TEST
if [ "$ENV" == "development" ]; then
vendor/bin/codecept build
fi
vendor/bin/codecept run --coverage --xml --html
