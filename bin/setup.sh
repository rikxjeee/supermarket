#!/bin/bash

echo 'Hello';

cd ../docker || exit
docker-compose up -d
while ! docker exec smarket-mysql mysqladmin --user=root --password=simple --host "127.0.0.1" ping --silent &> /dev/null ; do
    echo "Waiting for database connection..."
    sleep 5
done
echo 'Populating database with development data.'
docker exec docker_php-fpm_1 php /site/bin/setup.php
exitcode=$?

if [ $exitcode == 0 ]; then
  composer install -a
    # rm ../bin/setup.php
    # rm ../bin/setup.php
    echo 'Operation succesful.'
    else
      echo 'Operation failed, try again.'
fi
