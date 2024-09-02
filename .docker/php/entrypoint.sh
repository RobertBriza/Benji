#!/bin/bash

set -e

until nc -z -v -w30 $POSTGRES_HOST 5432; do
  echo "Waiting for database connection..."
  sleep 1
done

cd /var/www/html
composer install
php bin/console app:generate-config
#php bin/console migrations:migrate

echo "Done!"

cron

echo "Cron up!"

docker-php-entrypoint $@
