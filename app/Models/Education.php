<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

#[Table('educations')]
#[Fillable(['name', 'degree','start_date','end_date','user_id'])]
class Education extends Model
{
    use HasUuids;

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, "user_id","id");
    }
}
