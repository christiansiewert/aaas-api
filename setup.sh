#!/bin/bash

# Install Composer dependencies
composer install

# Generate OpenSSL certificate
openssl genrsa -out config/jwt/private.pem -aes256 4096 -passout pass:app!
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem -aes256 4096 -passin pass:app!

# Generate OpenSSL certificate for our test suite
docker-compose exec php openssl genrsa -out config/jwt/private-test.pem -aes256 4096  -passout pass:app!
docker-compose exec php openssl rsa -pubout -in config/jwt/private-test.pem -out config/jwt/public-test.pem  -passin pass:app!

# Populate database with schema
php bin/console doctrine:migrations:migrate --no-interaction

# Populate test database with schema and install fixtures
# docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction --env=test
# docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction --env=test

# Download Symfony binary and export $PATH
wget https://get.symfony.com/cli/installer -O - | bash && \
export PATH="$HOME/.symfony/bin:$PATH"