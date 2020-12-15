<?php

if (app()->isLocal() || app()->runningUnitTests()) {
    require __DIR__ . '/web/tests.php';
}

require __DIR__ . '/web/public.php';

require __DIR__ . '/web/auth.php';

require __DIR__ . '/web/business.php';
