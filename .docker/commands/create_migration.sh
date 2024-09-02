#!/bin/bash

cd ../../

rm -rf ./temp/cache
docker-compose exec web bash -c "php bin/console migrations:diff --no-interaction"
docker-compose exec web bash -c "php bin/console migrations:migrate --no-interaction"