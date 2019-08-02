#!/bin/bash

docker-compose stop && docker-compose up -d
while ! docker exec supermarket_mysql_1 mysqladmin --user=root --password=simple --host "127.0.0.1" ping --silent &> /dev/null ; do
    echo "Waiting for database connection..."
    sleep 5
done
echo 'Populating database with development data.'
docker exec supermarket_php-fpm_1 php /var/www/supermarket/bin/setup.php
exitcode=$?

if [ $exitcode == 0 ]; then
  docker-compose exec php-fpm composer install -a
    echo 'Operation succesful.'
    else
      echo 'Operation failed, try again.'
fi
