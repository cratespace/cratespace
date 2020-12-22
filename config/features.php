<?php

use App\Features\AppFeatures;
use App\Features\AuthFeatures;

return [
    /*
     * General Application Specific Features.
     */
    'app' => [
        AppFeatures::apiToken(),
        AppFeatures::profilePhoto(),
    ],

    /*
     * User Authentication Specific Features.
     */
    'auth' => [
        AuthFeatures::signin(),
        AuthFeatures::signup(),
        AuthFeatures::passwordReset(),
        // AuthFeatures::emailVerification(),
        AuthFeatures::passwordConfirmation(),
        AuthFeatures::twoFactorAuthentication(),
        AuthFeatures::otherBrowserSessions(),
    ],
];
