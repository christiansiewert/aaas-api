[![License: MIT](https://img.shields.io/github/license/siewert87/aaas-api.svg)](https://opensource.org/licenses/MIT)
[![Travis Status](https://img.shields.io/travis/siewert87/aaas-api.svg)](https://travis-ci.org/siewert87/aaas-api)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/siewert87/aaas-api.svg)](https://scrutinizer-ci.com/g/siewert87/aaas-api)
![Code Size](https://img.shields.io/github/languages/code-size/siewert87/aaas-api.svg)
[![Latest Tag](https://img.shields.io/github/tag/siewert87/aaas-api.svg?)](https://github.com/siewert87/aaas-api/releases)

# API as a Service - API

This is the API for _API as a Service_.

With _API as a Service_ you can easily build PHP APIs via a GUI.

## Table of Contents

1. [Essential](#essential)
2. [Installation](#installation)
3. [Visit Docs](#visit-docs)
4. [Useful commands for development](#useful-commands-for-development)
5. [Continuous Integration](#continuous-integration)
6. [Wiki](#wiki)

## Essential

#### Requirements

* [Docker] and [Docker Compose]
* [Docker Sync] if you want to develop at full speed on OSX or Windows (Optional)

#### Configuration

Application configuration is stored in `.env` file. 

#### Application environment
You can change application environment to `dev` of `prod` by changing `APP_ENV` variable in `.env` file.

#### Database and credentials
An `app` database is created by default with user `app` and password `app`. root password is `app`.

## Installation

### Start Containers 

Run 

```bash
docker-compose up
```

to start docker containers.

If you want to use `Docker Sync` on OSX or Windows you can run

```bash
docker-sync-stack start
```

from your WSL console instead.

### Build Backend

#### Install dependencies

```bash
docker-compose exec php composer update
```

If composer runs out of memory when doing this the first time you should run

```bash
docker-compose exec php COMPOSER_MEMORY_LIMIT=-1 composer update
```

#### Generate JWT Certificate

```bash
docker-compose exec php openssl genrsa -out config/jwt/private.pem -aes256 4096
docker-compose exec php openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

Don't forget to update `JWT_PASSPHRASE` in `.env` file. By default it's `app!`

### Deploy Database Schema

Update database credentials in `.env` and deploy schema:

```bash
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

If you want to modify the entities, don't forget to run:

```bash
docker-compose exec php php bin/console doctrine:migrations:diff
```

If you want to load the fixtures run:

```bash
docker-compose exec mariadb sh -c "mysql -u app -p app < /app/docs/db_fixtures.sql"
```

## Visit Docs

For [Swagger UI] open https://localhost in your browser.

## Useful commands for development

It is recommended to add short aliases for the following frequently used container commands:

* `docker-compose exec php /bin/bash` to run a shell inside the php container
* `docker-compose exec php php` to run php in container
* `docker-compose exec php php bin/console` to run Symfony CLI commands
* `docker-compose exec php php bin/console cache:clear` to clear cache
* `docker-compose exec php composer update` to update composer dependencies
* `docker-compose exec mariadb mysql -u app -p app` to run MySQL commands

## Continuous Integration

#### Running PHPUnit Tests

```bash
docker-compose exec php php bin/phpunit
```

#### Generate PHP CodeSniffer XML Report

```bash
docker-compose exec php php vendor/bin/phpcs --report=xml --report-file=build/ci/phpcs.xml
```

#### Generate PHPUnit Code Coverage HTML Report

```bash
docker-compose exec php php bin/phpunit --coverage-html build/ci/coverage
```

#### Generate PHP Mess Detector HTML Report

```bash
docker-compose exec php php vendor/bin/phpmd src/ html phpmd.xml.dist --reportfile build/ci/phpmd.html
```

#### Generate PHP Depend Metrics

```bash
docker-compose exec php php vendor/bin/pdepend --summary-xml=build/ci/php-pdepend.xml \
--jdepend-chart=build/ci/php-jdepend.svg --overview-pyramid=build/ci/php-pyramid.svg \
--ignore=src/Migrations/ src/
```

## Wiki

Visit [AaaS-API-Wiki] to familiarize yourself with the possibilities of AaaS API.

[Docker]: https://docs.docker.com/engine/installation
[Docker Compose]: https://docs.docker.com/compose/install/
[Swagger UI]: https://swagger.io/tools/swagger-ui/
[Docker Sync]: http://docker-sync.io/
[AaaS-API-Wiki]: https://github.com/siewert87/aaas-api/wiki



