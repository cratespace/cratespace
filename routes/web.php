<?php

if (! app()->isProduction()) {
    /**
     * Public Routes...
     */
    require 'web/tests.php';
}

/*
 * Public Routes...
 */
require 'web/public.php';

/*
 * Authentication Routes...
 */
require 'web/auth.php';

/*
 * Business Customer Routes...
 */
require 'web/business.php';

/*
 * Customer Support Routes...
 */
require 'web/support.php';

/*
 * User Routes...
 */
require 'web/user.php';
