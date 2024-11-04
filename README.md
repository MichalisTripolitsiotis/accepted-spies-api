# Accepted Backend Developer Coding Challenge

## Spies RESTful API

## Requirements

- Docker
- Composer
- MySQL

## Installation
Follow the steps below to install and set up the application:
1. Install [Docker](https://www.docker.com/) in case it is not already installed
2. Clone the repository
3. Run ```composer install``` to install all the required PHP dependencies
4. Copy the `.env.example` file to `.env` by running: `cp .env.example .env`
5. Make any changes you want (currently the `.env.example` has been configured to use sail)
6. Run sail: ```./vendor/bin/sail up [-d]``` (optionally you can create a [sail alias](https://laravel.com/docs/11.x/sail#configuring-a-shell-alias))
7. Create a new `APP_KEY` with this command: ```sail artisan key:generate ```
8. Migrate the database: ```sail artisan migrate```
9. Seed the database with some locations: ```sail artisan db:seed```
10. Import the Postman collection from this repository locally
11. Create a new environment variable called token

## Things for improvement
1. The Spy Creation could run in a queue:
Creating a new `IlluminateQuableCommandBus` that implements `ShouldQueue` and a new `QuableCommandBus` I think could work.
2. Filtering/Sorting
Currently there is a service to handle the filters/sorting for the spies. This is quite specific, a good approach would be to have something more generic that it could be reused from other entities as well.
3. Making generic Value Objects:
Instead of having specific value objects for each field, it could be based on the variable type e.g. String, Boolean, Date, DateTime, Int etc.
4. Improve tests to avoid dependencies on Laravel
Mainly the feature tests, depend on the Laravel Models. This could change to focus more on testing behavior.
