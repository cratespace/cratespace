# Running tests

Cratespace uses PHPUnit for testing. To clone cratespace into your local machine and run tests, simply open up your preferred terminal application, navigate into cratespace project root directory and run the following command.

Cratespace Test Suite uses network connection to run some tests.

```bash
git clone git@github.com:cratespace/cratespace.git
cd cratespace && composer install && npm install && npm run dev

# To run all tests including tests that require a working network connection.
composer test

# To run only offline tests
composer test-offline
```
