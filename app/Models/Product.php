<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\ProductLink;
use App\Models\Tech;

#[Fillable(['name', 'description','task','image', 'image_public_id', 'start_date','end_date','user_id'])]
class Product extends Model
{
    use HasUuids;
    protected $with = ['techs', 'links'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, "user_id","id");
    }

    public function links(): HasMany{
        return $this->hasMany(ProductLink::class, 'product_id','id');
    }

    public function techs():BelongsToMany{
        return $this->belongsToMany(Tech::class,'product_techs','product_id','tech_id')->using(ProductTech::class);
    }
}
