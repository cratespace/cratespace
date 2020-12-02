# Cratespace

## Introduction

### What is it?

Cratespace is a cloud-based web application that provides a platform for logistics services to market small freight spaces that are available during shipping.

### What does it offer?

Cratespace offers a place for logistics services to manage and market small freight spaces that become available when shipping freight containers are partially loaded with cargo during shipping.

### Who is it for?

The business is mostly focused towards logistics services and customers who require just a small amount of space to ship goods.

## Development

### Installing

Clone the repository to get started. If you do not have the required permissions, please contact <tjthavarshan@gmail.com>.

* To run this project, you must have PHP 7.4 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet. 
* If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart).

```bash
# Clone project.
git clone git@github.com:cratespace/cratespace.git

# Install dependencies.
cd cratespace && chmod +x bin/setup.sh && bash bin/setup.sh
```

### Seeding Default User

Cratespace application comes pre-configured with default user data that will be seeded on database seeding command. It can also be triggered by console command specifically for default user account seeding.

##### Default User Command

To seed or create default user account through specific artisan command just run the following command and follow the instructions displayed on the terminal window.

```bash
php artisan user:create
```

Next, boot up a server and visit cratespace landing page. If using a tool like Laravel Valet, of course the URL will default to `http://cratespace.test`. 

1. Visit: `http://cratespace.test/login` to sign in as an administrator.
2. Edit `config/auth.php`, and add any email address that should be marked as an administrator under `administrators` key.
3. Visit: `http://cratespace.test/admin/dashboard` to get started on the metrics.

## Running tests

Cratespace uses PHPUnit for testing. To clone cratespace into your local machine and run tests, simply open up your preferred terminal application, navigate into cratespace project root directory and run the following command.

Cratespace Test Suite uses network connection to run some tests.

```bash
# To run all tests including tests that require a working network connection.
composer test

# To run only offline tests.
composer test-offline
```

## Authors

* **Thavarshan Thayananthajothy** - *Initial work* - [Thavarshan](https://github.com/Thavarshan)

See also the list of [contributors](https://github.com/Thavarshan/cratespace/contributors) who participated in this project.
