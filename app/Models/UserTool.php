<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('user_tools')]
class UserTool extends Pivot
{
    use HasUuids;
}
