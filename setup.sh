#!/bin/bash

# Install Composer dependencies
composer install

# Generate OpenSSL certificate
openssl genrsa -out config/jwt/private.pem -aes256 -passout pass:app! 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem -passin pass:app!

# Generate OpenSSL certificate for our test suite
openssl genrsa -out config/jwt/private-test.pem -aes256 -passout pass:app! 4096
openssl rsa -pubout -in config/jwt/private-test.pem -out config/jwt/public-test.pem -passin pass:app!

# Create databases
mysql -e 'CREATE DATABASE app;'
mysql -e 'CREATE DATABASE app_test;'

# Populate database with schema
php bin/console doctrine:migrations:migrate --no-interaction

# Populate test database with schema and install fixtures
php bin/console doctrine:migrations:migrate --no-interaction --env=test
php php bin/console doctrine:fixtures:load --no-interaction --env=test