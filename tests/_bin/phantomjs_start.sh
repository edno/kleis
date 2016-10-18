#!/bin/bash

echo "PhantomJS (`phantomjs -v`)"

phantomjs --webdriver=4444 >/dev/null &

sleep 5
