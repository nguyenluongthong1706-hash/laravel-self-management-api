<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

#[Fillable(['level1', 'level2','level3','detail','user_id'])]
class Location extends Model
{
    use HasUuids;

    public function user():BelongsTo{
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
