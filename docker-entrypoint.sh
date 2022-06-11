#!/bin/bash
sleep 5
mysql --user=root --password=root --host=mariadb choupis < /var/www/html/src/choupis.sql
exec docker-php-entrypoint "$@"
