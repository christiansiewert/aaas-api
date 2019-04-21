# API as a Service API

This is the API as a Service API.

With API as a Service you can easily build PHP APIs via a GUI.

# Installation Instructions

## Requirements

* [Docker and Docker Compose](https://docs.docker.com/engine/installation)

## Configuration

Application configuration is stored in `.env` file. 

### Application environment
You can change application environment to `dev` of `prod` by changing `APP_ENV` variable in `.env` file.

### DB name and credentials
An `app` database is created by default with user `app` and password `app`. root password is `app`.

## Installation

### 1. Start Containers 

```bash
docker-compose up
```

### 2. Build Backend

Install dependencies

```bash
docker-compose exec php composer install
```

Generate JWT Certificate

```bash
$ docker-compose exec php openssl genrsa -out config/jwt/private.pem -aes256 4096
$ docker-compose exec php openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

Don't forget to update JWT_PASSPHRASE in `.env` file.

### 3. Build Database

```bash
docker-compose exec php bin/console doctrine:migrations:migrate
```

Don't forget to run

```bash
docker-compose exec php bin/console doctrine:migrations:diff
```

when you are updating your entities.

# Visit Docs

For swagger ui open https://localhost in your browser.

# Useful commands and shortcuts

## Shortcuts
It is recommended to add short aliases for the following frequently used container commands:

* `docker-compose exec php /bin/bash` to run a shell inside the php container
* `docker-compose exec php php` to run php in container
* `docker-compose exec php bin/console cache:clear` to clear cache
* `docker-compose exec php composer update` to update composer dependencies
* `docker-compose exec php bin/console` to run Symfony CLI commands
* `docker-compose exec php bin/console doctrine:migrations:diff` to run a diff on your database when editing entities
* `docker-compose exec php bin/console --no-interaction doctrine:migrations:migrate` run run the database migration
* `docker-compose exec mariadb mysql` to run MySQL commands

## Running tests

Run PHP Unit Tests:
```bash
docker-compose exec php vendor/bin/simple-phpunit
```