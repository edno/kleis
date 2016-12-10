#!/bin/bash

echo "PhantomJS (`phantomjs -v`)"

if ! pgrep "phantomjs" > /dev/null 2>&1
then
    phantomjs --webdriver=4444 >/dev/null &
fi

sleep 5
