#!/bin/bash

if pgrep "phantomjs" > /dev/null 2>&1
then
    kill `pgrep phantomjs` || true
fi
