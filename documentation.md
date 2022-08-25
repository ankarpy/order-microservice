
# Documentation

### General info

#### The task was developed using Laravel v9.25.1 (on PHP v8.1.6).

The API functions are written mainly in the Api\OrderController class,
but I created individual request classes for the validation logic (that can be found in the Requests folder).

Due to security reasons, I created an `ApiKeyMiddleware` class, which I added to the api middleware groups in the Kernel:
therefore the api-key (`test`) must be passed on any time a request is made to the endpoints.

The swagger documentation can be found at the following route: `/api/documentation`



### Installation


Clone the project

Open terminal and navigate to the project's folder

Run `composer install` to install the composer dependencies

Copy the example config file with the following command: `cp .env.example .env`

Open your **.env** file and set the **DB_DATABASE**, **DB_USERNAME** and **DB_PASSWORD** to the desired values.

Run `php artisan key:generate` to generate appliaction key

Run `php artisan migrate:fresh --seed` to migrate the database and fill it up with test data

Run `php artisan serve` to serve the appliaction

Done!
