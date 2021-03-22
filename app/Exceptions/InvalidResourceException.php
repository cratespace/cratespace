<?php

namespace App\Exceptions;

use InvalidArgumentException;
use Stripe\Exception\ExceptionInterface;

class InvalidResourceException extends InvalidArgumentException implements ExceptionInterface
{
}
