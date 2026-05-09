<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

#[Fillable(['position', 'place_at','start_date','end_date','user_id'])]
class WorkExperience extends Model
{
    use HasUuids;

    protected function user(): BelongsTo{
        return $this->belongsTo(User::class, "user_id","id");
    }
}
