#!/bin/bash
# Error control

set -u;
set -e;

cd ../
read -p "Please type pulled GIT Branch: " GIT_BRANCH
git pull origin $GIT_BRANCH

read -p "Press [Enter] key to update dependencies..." DEP
bower update