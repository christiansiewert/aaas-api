<p align="center">
    <img src="https://raw.githubusercontent.com/christiansiewert/aaas-api/develop/docs/logo.png" alt="API as a Service" />
</p>

# API as a Service - API

This is the API for _API as a Service_.

With _API as a Service_ you can easily build PHP APIs via a GUI.

If you want to try out our application quickly in the cloud, you can set it up as a workspace in Gitpod. Otherwise, please continue reading.

[![Open in Gitpod](https://gitpod.io/button/open-in-gitpod.svg)](https://gitpod.io/#https://github.com/christiansiewert/aaas-api/tree/develop)

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

To start the docker containers execute: 

```bash
docker-compose up
```

If you want to use `Docker Sync` on OSX or Windows you can execute the command below from your OSX- or WSL-Console instead:

```bash
docker-sync-stack start
```

### Build Backend

#### Install dependencies

```bash
docker-compose exec php composer update
```

If composer runs out of memory when doing this the first time you should run

```bash
docker-compose exec -e COMPOSER_MEMORY_LIMIT=-1 php composer update
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
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

### Create an administrator account

You should create an administrator account:

```bash
docker-compose exec php php bin/console acl:create-user EMAIL PASSWORD --admin
```

### Retrieving an JWT Access Token

You can retrieve an JWT Access Token by posting your credentials to `/auth/login_check`:

```bash
curl -X POST -H "Content-Type: application/json" http://localhost/auth/login_check \
-d '{ "email" : "EMAIL", "password" : "PASSWORD" }'
```

If your credentials are correct the server should respond with an JWT Access Token:

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOcm9sZXMiOlsiUk9MRV9..."
}
```

Do not forget to send an `Authorization` HTTP-Header when requesting `/aaas` resources and set the value to `Bearer YOUR_TOKEN`. You get an `401 Unauthorized Error` otherwise. See more information about that in our [Wiki].

## Visit Docs

For [Swagger UI] open https://localhost/docs in your browser. 

Please note that Swagger UI is disabled when you set `APP_ENV` to `prod` in `.env`. 

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

Our test suite uses an ``app_test`` database whose container service can be viewed under ``mariadb_test`` in ``docker-compose.yml``. You should run the commands below to populate this database with our schema and to load the data fixtures if you want to run the tests.

```bash
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction --env=test
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction --env=test
```

The test environment uses another SSL key pair. Do not forget to generate it. Add ``-passout pass:app!`` when generating the private key and ``-passin pass:app!`` when generating the public key if you want to skip interaction.

```bash
docker-compose exec php openssl genrsa -out config/jwt/private-test.pem -aes256 4096
docker-compose exec php openssl rsa -pubout -in config/jwt/private-test.pem -out config/jwt/public-test.pem
```

If you want to run the testsuite execute the command below:

```bash
docker-compose exec php php bin/phpunit -c config/ci/phpunit.xml.dist
```

#### Generate PHP CodeSniffer XML Report

```bash
docker-compose exec php php vendor/bin/phpcs --report=xml --report-file=build/ci/phpcs.xml --standard=config/ci/phpcs.xml.dist
```

#### Generate PHPUnit Code Coverage HTML Report

```bash
docker-compose exec php php bin/phpunit -c config/ci/phpunit.xml.dist --coverage-html build/ci/coverage
```

#### Generate PHP Mess Detector HTML Report

```bash
docker-compose exec php php vendor/bin/phpmd src/ html config/ci/phpmd.xml.dist --reportfile build/ci/phpmd.html
```

#### Generate PHP Depend Metrics

```bash
docker-compose exec php php vendor/bin/pdepend --summary-xml=build/ci/php-pdepend.xml \
--jdepend-chart=build/ci/php-jdepend.svg --overview-pyramid=build/ci/php-pyramid.svg \
--ignore=src/Migrations/ src/
```

## Wiki

Visit our [Wiki] to familiarize yourself with the possibilities of AaaS API.

[Docker]: https://docs.docker.com/engine/installation
[Docker Compose]: https://docs.docker.com/compose/install/
[Swagger UI]: https://swagger.io/tools/swagger-ui/
[Docker Sync]: http://docker-sync.io/
[Wiki]: https://aaas-api.readthedocs.io



