<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('user_techs')]
class UserTech extends Pivot
{
    use HasUuids;
}
