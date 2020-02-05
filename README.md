# Relaxing Sounds App

## Prerequisites

* Access to an Ubuntu 18.04 local machine or development server as a non-root user with sudo privileges.

* [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu) installed on your server.

* [Docker Compose](https://docs.docker.com/compose/install) installed on your server.

## Install & Build

* Pull the repo.

* Run `cp .env.example .env`.

* Build the app image `docker-compose build app`.

* Run the environment in background mode `docker-compose up -d`.

* Run composer install `docker-compose exec app composer install`.

* Generate a unique application key `docker-compose exec app php artisan key:generate`.

* Generate JWt secret key `php artisan jwt:secret`.
