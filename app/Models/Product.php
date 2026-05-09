<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\ProductUrl;
use App\Models\Tech;

#[Fillable(['name', 'description','task','image','start_date','end_date','user_id'])]
class Product extends Model
{
    use HasUuids;

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, "user_id","id");
    }

    public function urls(): HasMany{
        return $this->hasMany(ProductUrl::class, 'product_id','id');
    }

    public function techs():BelongsToMany{
        return $this->belongsToMany(Tech::class,'product_techs','product_id','tech_id')->using(ProductTech::class);
    }
}
