<?php

declare(strict_types=1);

namespace App\CQRS\Exceptions;

use Exception;

class SavingImmutableModel extends Exception
{
    protected $message = 'Cannot save read-only model.';
}
