#!/usr/bin/env bash
COMPOSER=composer-dev.json php -d memory_limit=8096M /usr/bin/composer update $1
