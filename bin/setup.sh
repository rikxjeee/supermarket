#!/bin/bash

DIR=$(dirname $(readlink -f "${BASH_SOURCE[0]}" 2>/dev/null||echo $0))

cd $DIR/../docker && docker-compose stop && docker-compose up -d && cd - || exit
while ! docker exec smarket-mysql mysqladmin --user=root --password=simple --host "127.0.0.1" ping --silent &> /dev/null ; do
    echo "Waiting for database connection..."
    sleep 5
done
echo 'Populating database with development data.'
cd $DIR/../bin && docker exec smarket-php php /site/bin/setup.php && cd -|| exit
exitcode=$?

if [ $exitcode == 0 ]; then
  cd $DIR/../docker && docker-compose exec php-fpm composer install -a && cd -
    echo 'Operation succesful.'
    else
      echo 'Operation failed, try again.'
fi
