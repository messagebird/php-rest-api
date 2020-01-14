#!/bin/bash
TRAVIS_PHP_VERSION=7.5
V=`echo -e "$TRAVIS_PHP_VERSION\n7.0" | sort -Vr | head -n1`
echo $V
if [ `echo -e "$TRAVIS_PHP_VERSION\n7.0" | sort -Vr | head -n1` == 7.0 ]; then echo "yo"; fi
