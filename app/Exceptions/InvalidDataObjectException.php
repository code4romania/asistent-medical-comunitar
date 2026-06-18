<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidDataObjectException extends Exception
{
    protected $message = 'The data object must have a "current" and "previous" property.';
}
