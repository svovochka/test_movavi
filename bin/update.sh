#!/bin/bash

set -x
set -e

# define file directory
ROOT=$(dirname $(dirname $0))

# Go to root directory
cd $ROOT

# Set rights
sudo chmod -R 777 var/cache
sudo chmod -R 777 var/logs
sudo chmod -R 777 var/sessions

# Clean cache and logs
sudo rm -rf var/cache/prod/
sudo rm -rf var/cache/dev/

# Install composer dependencies
composer install

# Perform database updates
# php bin/console doctrine:schema:update --force --env=prod
php bin/console doctrine:migrations:migrate --no-interaction --env=prod --allow-no-migration

# Install assets
php bin/console assets:install --env=prod
#php bin/console assetic:dump --env=prod

# Clean cache and logs
sudo rm -rf var/cache/prod/
sudo rm -rf var/cache/dev/