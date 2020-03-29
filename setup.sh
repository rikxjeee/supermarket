#!/bin/bash

docker-compose stop && docker-compose up -d
while ! docker-compose exec mysql mysqladmin --user=root --password=simple --host "127.0.0.1" ping --silent &> /dev/null ; do
    echo "Waiting for database connection..."
    sleep 5
done
echo 'Populating database with development data.'
docker-compose exec php-fpm php bin/setup.php
exitcode=$?

if [ $exitcode == 0 ]; then
  docker-compose exec php-fpm composer install -a
    echo 'Operation succesful.'
    else
      echo 'Operation failed, try again.'
fi
