<?php

declare(strict_types=1);

/*
 * Auth Routes...
 */
Auth::routes();

/*
 * Auth Business Routes...
 */
require 'web/business.php';

/*
 * Users Routes...
 */
require 'web/user.php';

/*
 * Support Routes...
 */
require 'web/support.php';

/*
 * Admin Routes...
 */
require 'web/admin.php';

/*
 * Public Routes...
 */
require 'web/public.php';
