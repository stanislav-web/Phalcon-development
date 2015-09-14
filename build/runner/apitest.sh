#!/bin/bash

# Define variables
export SET BUILD="vendor/bin/codecept build"
export SET RUN="vendor/bin/codecept run --coverage --xml --html"

# Start test

start() {
    $1;
    $2;
}

# Request wishes
read -p "Press [Enter] to start api testing: " START
start $BUILD $RUN