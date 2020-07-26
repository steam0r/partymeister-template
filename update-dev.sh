#!/usr/bin/env bash
COMPOSER=composer-dev.json php -d memory_limit=8096M ./composer.phar  -vvvv install $1
