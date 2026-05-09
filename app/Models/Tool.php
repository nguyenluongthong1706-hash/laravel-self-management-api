<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

#[Fillable(['name', 'icon'])]
class Tool extends Model
{
    use HasUuids;

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class,'user_tools','tool_id','user_id')->using(UserTool::class);
    }
}
