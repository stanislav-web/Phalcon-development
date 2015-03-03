#!/bin/bash
# Error control

set -u;
set -e;

# Define variables
OSTYPE="`uname`"
export SET GIT_BRANCH='Frontend';

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
git pull origin $GIT_BRANCH
bower update
composer update
composer install -o
vendor/bin/codecept build
vendor/bin/codecept run