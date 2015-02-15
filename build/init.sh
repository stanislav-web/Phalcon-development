#!/bin/bash
# Error control

set -u;
set -e;

# Define variables

export SET GIT_BRANCH='Frontend';

sudo service php5-fpm restart
sudo service nginx restart
sudo service mysql restart
sudo service memcached restart

cd ../
git pull origin $GIT_BRANCH
bower update
composer install -o