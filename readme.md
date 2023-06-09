# Task App

Prerequisite php 8.1
## Installation

Clone the repo locally:

```sh
git clone git@github.com:David-Rosas/task-app.git
cd task-app
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```


Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Visit Ping CRM in your browser, and login with:

- **Username:** davidr@example.com
- **Password:** 123123

## Running tests

To run the Task App, run:

```
phpunit
```
