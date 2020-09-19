# Createspace

![GitHub](https://github.com/cratespace/cratespace/workflows/GitHub/badge.svg)

### What is Cratespace?

Cratespace is a cloud-based web application that provides a platform for logistics services to market small freight spaces that are available during shipping.

### What does Cratespace offer?

Cratespace offers a place for logistics services to manage and market small freight spaces that become available when shipping freight containers are partially loaded with cargo during shipping.

### Who is Cratespace for?

The business is mostly focused towards logistics services and customers who require just a small amount of space to ship goods.

## Development

### Installing

Clone the repository to get started. If you do not have the required permissions, please contact <tjthavarshan@gmail.com>.

* To run this project, you must have PHP 7.4 installed.
* You should setup a host on your web server for your local domain. For this you could also configure Laravel Homestead or Valet. 
* If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart).

```bash
git clone git@github.com:cratespace/cratespace.git
cd cratespace && composer install && npm install && npm run dev
```

Next, boot up a server and visit cratespace landing page. If using a tool like Laravel Valet, of course the URL will default to `http://cratespace.test`. 

1. Visit: `http://cratespace.test/login` to sign in as an administrator.
2. Edit `config/auth.php`, and add any email address that should be marked as an administrator under `administrators` key.
3. Visit: `http://cratespace.test/admin/dashboard` to get started on the metrics.

## Running tests

Cratespace uses PHPUnit for testing. To clone cratespace into your local machine and run tests, simple open up your preferred terminal application, navigate into cratespace project root directory and run the following command..

```bash
git clone git@github.com:cratespace/cratespace.git
cd cratespace && composer install && npm install && npm run dev
composer test
```

## Authors

* **Thavarshan Thayananthajothy** - *Initial work* - [Thavarshan](https://github.com/Thavarshan)

See also the list of [contributors](https://github.com/Thavarshan/cratespace/contributors) who participated in this project.
