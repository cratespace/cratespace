# Installing

## Server Requirements

The Cratespace web application has a few system requirements. All of these requirements are satisfied by the Homestead virtual machine, so it's highly recommended that you use Homestead / valet as your local development environment.

However, if you are not using Homestead / valet, you will need to make sure your server meets the following requirements:

- PHP >= 7.4.9
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- Int PHP Extension
- XML PHP Extension

Cratespace uses PHP's built in NumberFOrmatter classes for currency formatting, so make sure you have Int PHP extension installed on your local development and deployment environment.

## Installing Cratespace

Since Cratespace is built with Laravel and Laravel utilizes Composer to manage its dependencies. So, before using Cratespace, make sure you have Composer installed on your machine.

Clone the repository to get started. If you do not have the required permissions, please contact <tjthavarshan@gmail.com>.

```bash
git clone git@github.com:cratespace/cratespace.git
cd cratespace && composer install && npm install && npm run dev
```

## Automated Installation Process

Next thing you should do is to run the built in installation process for Cratespace. Since a few configurations have to be made all requirements are automated through this process.

```bash
php artisan cratespace:install
```

This process includes:

- Set application key
- Set environment
- Set database configurations
- Set session configurations

**If the application key is not set, your user sessions and other encrypted data will not be secure!**

## Local Development Server

If you have PHP installed locally and you would like to use PHP's built-in development `server` to serve your application, you may use the serve Artisan command. This command will start a development server at `http://localhost:8000`:

```bash
php artisan serve
```

More robust local development options are available via [Homestead](https://laravel.com/docs/8.x/homestead) and [Valet](https://laravel.com/docs/8.x/valet).

Next, boot up the server and visit cratespace landing page. If using a tool like Laravel Valet, of course the URL will default to [http://cratespace.test](http://cratespace.test).

1. Visit: [http://cratespace.test/login](http://cratespace.test/login) to sign in as an administrator.
2. Edit `config/auth.php`, and add any email address that should be marked as an administrator under `administrators` key.
3. Visit: [http://cratespace.test/admin/dashboard](http://cratespace.test/admin/dashboard) to get started on the metrics.
