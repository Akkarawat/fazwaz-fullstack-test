# About this project

This project consists of:

- A **Laravel Backend** under `/html/backend`
- A **Next.js Frontend** under `/html/frontend`

# Laravel Backend

The Laravel backend connects to a **MySQL** database and exposes a GET API - `/api/properties` for the Next.js frontend.

## Installation

**Prerequisites**

- PHP 8.4
- Composer
- WSL2 - Required for Laravel Sail if you are using Windows.

**Steps**

Nagivate into `/html/backend`.

```
cd html/backend
```

Create `.env` file using `.env.example`.

```
cp .env.example .env
```

Install Dependencies.

```
composer install
```

Start Laravel Sail.

```
./vendor/bin/sail up -d
```

Run database migrations and seeders.

```
./vendor/bin/sail artisan migrate --seed
```

Verify that the API is up and running.

```
curl http://localhost:4000/api/properties
```

## Running Test Cases

Vertify various functionalities of the GET API - `/api/properties`.

```
./vendor/bin/sail artisan test
```

Expected results.

```
 PASS  Tests\Feature\GetPaginatedPropertyApiTest
  ✓ fetches properties successfully                                                                                      7.33s
  ✓ applies pagination correctly                                                                                         0.23s
  ✓ filters properties by province                                                                                       0.17s
  ✓ filters properties by country                                                                                        0.15s
  ✓ searches properties by title                                                                                         0.15s
  ✓ sorts properties by price ascending                                                                                  0.14s
  ✓ sorts properties by price descending                                                                                 0.16s
  ✓ filters properties with combined criteria                                                                            0.13s

  Tests:    8 passed (154 assertions)
  Duration: 10.25s
```

# Next.js Frontend

The Next.js frontend fetch data from GET API - `/api/properties` and display them on the following urls.

- `http://localhost:3000/properties`
- `http://localhost:3000/properties/[province]`

## Installation

**Prerequisites**

- Node.js 18.18 or later.

**Steps**

Nagivate into `/html/frontend`.

```
cd html/frontend
```

Install Dependencies.

```
npm install
```

Create `.env.local` file with the follow content.

```
NEXT_PUBLIC_API_BASE_URL=http://localhost:4000
```

Start the application.

```
npm run dev
```

The application should now be up and running.

![preview](https://github.com/Akkarawat/fazwaz-fullstack-test/html/frontend/public/app_preview.png)
