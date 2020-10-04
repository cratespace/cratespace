# Configuration

- [Introduction](#introduction)
- [Environment Configuration](#environment-configuration)
- [Cratespace Specific Configuration](#cratespace-specific-configuration)
- [Accessing Cratespace Defaults Configuration Values](#accessing-default-configuration-values)
- [Configuration Caching](#configuration-caching)
- [Maintenance Mode](#maintenance-mode)

<a name="introduction"></a>
## Introduction

All of the configuration files for the Laravel framework are stored in the `config` directory. Each option is documented, so feel free to look through the files and get familiar with the options available to you.

<a name="environment-configuration"></a>
## Environment Configuration

The root directory of the application will contain a `.env.example` file. If the automated installation process was run during initial setup, The `.env.example` should be copied to `.env`. Otherwise, you should copy the file manually.

Your `.env` file should not be committed to the application's source control, since each developer / server using the application could require a different environment configuration. Furthermore, this would be a security risk in the event an intruder gains access to your source control repository, since any sensitive credentials would get exposed.

<a name="cratespace-specific-configuration"></a>
## Cratespace Specific Configuration

Cratespace application has a few default configurations of its own. These include,

- Billing
    + Currency
    + Transaction description
    + Default chargeable amounts
    + Additional charges calculation classes.
- Default user profile and account details
- Default user profile photo storage area
- Default user business profile details
- Cratespace support details
    + Support request email address
    + Support agent maximum handled tickets
- Space details
    + Space supported types
    + Space purchase status
- Order details
    + Order statuses
- Support ticket details
    + Ticket statuses
    + Ticket priorities

<a name="accessing-default-configuration-values"></a>
## Accessing Cratespace Defaults Configuration Values

Cratespae deafult configuration details can be accessed by `config` method using `default` key.

For instance, default user details can be accessed like

```php
$user = config('defaults.user');

// This should output
[
    'username' => 'Thavarshan',
    'name' => 'Thavarshan Thayananthajothy',
    'email' => 'tjthavarshan@gmail.com',
    'phone' => '775018795',
    'email_verified_at' => now(),
    'password' => '$2y$10$8jakkFVc8175VAOGK5Jt/uDT4R9KEwJPdG5jEEceaxCHwyfhkLs2S', // alphaxion77
    'remember_token' => 'Wdd5eAC4tFBrM0c4qT1b1yGrePdlBzONsndKxjEx',
    'settings' => [
        'notifications_mobile' => 'everything',
        'notifications_email' => [
            'new-order', 'cancel-order', 'newsletter',
        ],
    ],
    'profile_photo_path' => null,
    'two_factor_secret' => null,
    'two_factor_recovery_codes' => null,
]
```

<a name="configuration-caching"></a>
## Configuration Caching

To give the application a speed boost, you should cache all of your configuration files into a single file using the `config:cache` Artisan command. This will combine all of the configuration options for the application into a single file which will be loaded quickly by the framework.

You should typically run the `php artisan config:cache` command as part of your production deployment routine. The command should not be run during local development as configuration options will frequently need to be changed during the course of the application's development.

> If you execute the `config:cache` command during your deployment process, you should be sure that you are only calling the `env` function from within your configuration files. Once the configuration has been cached, the `.env` file will not be loaded and all calls to the `env` function will return `null`.

<a name="maintenance-mode"></a>
## Maintenance Mode

When the application is in maintenance mode, a custom view will be displayed for all requests into the application. This makes it easy to "disable" the application while it is updating or when you are performing maintenance. A maintenance mode check is included in the default middleware stack for the application. If the application is in maintenance mode, a `MaintenanceModeException` will be thrown with a status code of 503.

To enable maintenance mode, execute the `down` Artisan command:

```bash
php artisan down
```

You may also provide a `retry` option to the `down` command, which will be set as the `Retry-After` HTTP header's value:

```bash
php artisan down --retry=60
```

#### Bypassing Maintenance Mode

Even while in maintenance mode, you may use the `secret` option to specify a maintenance mode bypass token:

```bash
php artisan down --secret="1630542a-246b-4b66-afa1-dd72a4c43515"
```

After placing the application in maintenance mode, you may navigate to the application URL matching this token and Laravel will issue a maintenance mode bypass cookie to your browser:

```bash
https://cratesapce.biz/1630542a-246b-4b66-afa1-dd72a4c43515
```

When accessing this hidden route, you will then be redirected to the `/` route of the application. Once the cookie has been issued to your browser, you will be able to browse the application normally as if it was not in maintenance mode.

#### Pre-Rendering The Maintenace Mode View

If you utilize the `php artisan down` command during deployment, your users may still occasionally encounter errors if they access the application while the Composer dependencies or other infrastructure components are updating. This occurs because a significant part of the Laravel framework must boot in order to determine the application is in maintenance mode and render the maintenance mode view using the templating engine.

For this reason, Laravel allows you to pre-render a maintenance mode view that will be returned at the very beginning of the request cycle. This view is rendered before any of the application's dependencies have loaded. You may pre-render a template of your choice using the `down` command's `render` option:

```bash
php artisan down --render="errors::503"
```

#### Redirecting Maintenance Mode Requests

While in maintenance mode, Laravel will display the maintenance mode view for all application URLs the user attempts to access. It is possible to instruct Laravel to redirect all requests to a specific URL. This may be accomplished using the `redirect` option. For example, you may wish to redirect all requests to the `/` URI:

```bash
php artisan down --redirect=/
```

#### Disabling Maintenance Mode

To disable maintenance mode, use the `up` command:

```bash
php artisan up
```

> Default maintenance mode template can be customized by editing `resources/views/errors/503.blade.php` view file.

#### Maintenance Mode & Queues

While the application is in maintenance mode, no *queued* jobs will be handled. The jobs will continue to be handled as normal once the application is out of maintenance mode.
