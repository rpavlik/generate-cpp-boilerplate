#!/bin/sh
(
cd $(dirname $0)
./test-locally 2>&1 | grep Warning
if [ $? -eq 0 ]; then
  exit 1
else
  exit 0
fi
)
