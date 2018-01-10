<?php

declare(strict_types=1);

namespace App\CQRS\ReadModel;

use App\CQRS\Exceptions\SavingImmutableModel;
use Illuminate\Database\Eloquent\Model;

class ImmutableModel extends Model
{
    public function save(array $options = [])
    {
        throw new SavingImmutableModel();
    }
}
